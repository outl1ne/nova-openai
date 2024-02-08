<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings;

use Exception;
use Outl1ne\NovaOpenAI\Http;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Outl1ne\NovaOpenAI\Resources\Measurable;
use Outl1ne\NovaOpenAI\Resources\Embeddings\Responses\EmbeddingsResponse;

class CreateEmbedding
{
    use Measurable;

    protected $model;
    protected $input;
    protected $openaiRequest;

    public function __construct(
        protected readonly Http $http,
    ) {}

    public function pending()
    {
        $this->startMeasuring();

        $this->openaiRequest = new OpenAIRequest;
        $this->openaiRequest->method = 'embeddings';
        $this->openaiRequest->status = 'pending';
        $this->openaiRequest->model_requested = $this->model;
        $this->openaiRequest->input = $this->input;
        $this->openaiRequest->save();

        return $this->openaiRequest;
    }

    public function makeRequest(string $model, string $input): EmbeddingsResponse
    {
        $this->model = $model;
        $this->input = $input;

        $this->pending();

        try {
            $response = $this->http->client()->withHeader('Content-Type', 'application/json')->post('embeddings', [
                'model' => $this->model,
                'input' => $this->input,
            ]);
            $response->throw();

            return $this->handleResponse(new EmbeddingsResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse(EmbeddingsResponse $response)
    {
        $this->openaiRequest->time = $this->measure();
        $this->openaiRequest->status = 'success';
        $this->openaiRequest->response_object = $response->object;
        $this->openaiRequest->model_used = $response->modelUsed;
        $this->openaiRequest->output = $response->embeddings;
        $this->openaiRequest->usage_prompt_tokens = $response->usage->promptTokens;
        $this->openaiRequest->usage_total_tokens = $response->usage->totalTokens;
        $this->openaiRequest->ratelimit_limit_requests = $response->rateLimit->limitRequests;
        $this->openaiRequest->ratelimit_limit_tokens = $response->rateLimit->limitTokens;
        $this->openaiRequest->ratelimit_remaining_requests = $response->rateLimit->remainingRequests;
        $this->openaiRequest->ratelimit_remaining_tokens = $response->rateLimit->remainingTokens;
        $this->openaiRequest->ratelimit_reset_requests = $response->rateLimit->resetRequests;
        $this->openaiRequest->ratelimit_reset_tokens = $response->rateLimit->resetTokens;
        $this->openaiRequest->save();

        return $response;
    }

    public function handleException(Exception $e)
    {
        $this->openaiRequest->time = $this->measure();
        $this->openaiRequest->status = 'error';
        $this->openaiRequest->error = $e->getMessage();
        $this->openaiRequest->save();

        throw $e;
    }
}
