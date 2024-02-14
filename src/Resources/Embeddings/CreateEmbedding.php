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
    protected $request;

    public function __construct(
        protected readonly PendingRequest $http,
    ) {
    }

    public function pending()
    {
        $this->measure();

        $this->request = new OpenAIRequest;
        $this->request->method = 'embeddings';
        $this->request->status = 'pending';
        $this->request->model_requested = $this->model;
        $this->request->input = $this->input;
        $this->request->save();

        return $this->request;
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
        $this->request->time = $this->measure();
        $this->request->status = 'success';
        $this->request->response_object = $response->object;
        $this->request->model_used = $response->modelUsed;
        $this->request->output = $response->embedding;
        $this->request->usage_prompt_tokens = $response->usage->promptTokens;
        $this->request->usage_total_tokens = $response->usage->totalTokens;
        $this->request->save();

        return $response;
    }

    public function handleException(Exception $e)
    {
        $this->request->time = $this->measure();
        $this->request->status = 'error';
        $this->request->error = $e->getMessage();
        $this->request->save();

        throw $e;
    }
}
