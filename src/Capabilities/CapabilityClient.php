<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Closure;
use Exception;
use Outl1ne\NovaOpenAI\Capabilities\Responses\CachedResponse;
use Outl1ne\NovaOpenAI\OpenAI;
use Outl1ne\NovaOpenAI\Pricing\Calculator;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Illuminate\Http\Client\Response as HttpResponse;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

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
        return $response->getBody() instanceof \Psr\Http\Message\StreamInterface && $response->getBody()->isReadable();
    }

    protected function handleStreamedResponse(HttpResponse $response)
    {
        if (!$this->capability->streamCallback instanceof Closure) {
            throw new Exception('Response is a stream but stream callback is not defined.');
        }

        $body = $response->getBody();
        $i = 0;
        $rawResult = '';
        while (!$body->eof()) {
            $rawChunk = $body->read(1024);
            $rawResult .= $rawChunk;
            // dd($chunk);
            echo "[{$i}] ";
            echo $chunk;
            $i++;
            $result .= $chunk;
            ($this->capability->streamCallback)($chunk, $result);
        }

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
