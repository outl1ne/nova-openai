<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Closure;
use Exception;
use Outl1ne\NovaOpenAI\OpenAI;
use GuzzleHttp\Promise\Promise;
use Outl1ne\NovaOpenAI\StreamHandler;
use Psr\Http\Message\ResponseInterface;
use Outl1ne\NovaOpenAI\Pricing\Calculator;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamChunk;
use Outl1ne\NovaOpenAI\Capabilities\Responses\CachedResponse;

abstract class CapabilityClient
{
    use Measurable;

    public readonly OpenAI $openAI;
    protected OpenAIRequest $request;
    protected string $method;

    public function __construct(
        public readonly Capability $capability,
    ) {
        $this->openAI = $capability->openAI;
        $this->request = new OpenAIRequest;
        $this->request->method = $this->method;
        $this->request->arguments = [];
        if ($capability->streamCallback instanceof Closure) {
            $this->request->appendArgument('stream', true);
            $this->request->appendArgument('stream_options', [
                'include_usage' => true,
            ]);
        }
    }

    public function pending()
    {
        $this->measure();

        $this->request->status = 'pending';
        if (($this->capability->shouldStoreCallback)() && ($this->capability->shouldStorePendingCallback)()) {
            $this->request->save();
        }

        return $this->request;
    }

    public function store($response = null)
    {
        $this->request = ($this->capability->storingCallback)($this->request);

        if (($this->capability->shouldStoreCallback)($response)) {
            $this->request->save();
        }
    }

    protected function handleResponse(Response $response, ?callable $handleResponse = null)
    {
        $this->request->cost = $this->calculateCost($response);
        $this->request->time_sec = $this->measure();
        $this->request->status = 'success';
        $this->request->meta = $response?->meta;
        $this->request->model_used = $response?->model;
        $this->request->usage_prompt_tokens = $response->usage?->promptTokens;
        $this->request->usage_completion_tokens = $response->usage?->completionTokens;
        $this->request->usage_total_tokens = $response->usage?->totalTokens;
        if ($handleResponse !== null) $handleResponse($response);
        $this->store($response);

        $response->request = $this->request;

        return $response;
    }

    protected function isStreamedResponse(HttpResponse $response)
    {
        return strpos($response->getHeaderLine('Content-Type'), 'text/event-stream') !== false;
    }

    protected function handleStreamedResponse(Promise $promise, ?callable $handleResponse = null)
    {
        if (!$this->capability->streamCallback instanceof Closure) {
            throw new Exception('Response is a stream but stream callback is not defined.');
        }

        $chainedPromise = $promise->then(function (ResponseInterface $stream) {
            $response = (new StreamHandler($stream, $this->capability->streamCallback, function (StreamChunk $streamChunk) {
                $this->request->status = 'streaming';
                $this->request->meta = $streamChunk?->meta;
                $this->request->model_used = $streamChunk?->model;
                if (($this->capability->shouldStoreCallback)($streamChunk)) {
                    $this->request->save();
                }
            }))->handle();
            return $response;
        });
        $response = $chainedPromise->wait();

        $this->request->cost = $this->calculateCost($response);
        $this->request->time_sec = $this->measure();
        $this->request->status = 'success';
        $this->request->meta = $response?->meta;
        $this->request->usage_prompt_tokens = $response->usage?->promptTokens;
        $this->request->usage_completion_tokens = $response->usage?->completionTokens;
        $this->request->usage_total_tokens = $response->usage?->totalTokens;

        if ($handleResponse !== null) $handleResponse($response);
        $this->store($response);
        $response->request = $this->request;

        return $response;
    }

    protected function handleCachedResponse(CachedResponse $cachedResponse, ?callable $handleResponse = null)
    {
        $this->request->time_sec = $this->measure();
        $this->request->status = 'cache';
        if ($handleResponse !== null) $handleResponse($cachedResponse);
        $this->store();

        $cachedResponse->request = $this->request;

        return $cachedResponse;
    }

    public function handleException(Exception $e)
    {
        $this->request->time_sec = $this->measure();
        $this->request->status = 'error';
        $this->request->error = $e->getMessage();
        if (($this->capability->shouldStoreCallback)() && ($this->capability->shouldStoreErrorsCallback)($e)) {
            $this->request->save();
        }

        throw $e;
    }

    protected function calculateCost($response): ?float
    {
        if ($response->model === null || $response->usage === null) {
            return null;
        }
        return $this->pricing()->model($response->model)->calculate($response->usage->promptTokens, $response->usage->completionTokens);
    }

    protected function pricing(): Calculator
    {
        return $this->openAI->pricing->models();
    }
}
