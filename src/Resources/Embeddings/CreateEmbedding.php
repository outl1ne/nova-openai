<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings;

use Exception;
use Illuminate\Http\Client\PendingRequest;
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
        protected readonly PendingRequest $http,
    ) {
    }

    public function pending()
    {
        $this->measure();

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
            $response = $this->http->withHeader('Content-Type', 'application/json')->post('embeddings', [
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
        $this->openaiRequest->output = $response->embedding;
        $this->openaiRequest->usage_prompt_tokens = $response->usage->promptTokens;
        $this->openaiRequest->usage_total_tokens = $response->usage->totalTokens;
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
