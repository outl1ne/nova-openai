<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings;

use Exception;
use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Http;
use Outl1ne\NovaOpenAI\Models\OpenaiRequest;
use Outl1ne\NovaOpenAI\Resources\Measurable;

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

        $this->openaiRequest = new OpenaiRequest;
        $this->openaiRequest->method = 'embeddings';
        $this->openaiRequest->status = 'pending';
        $this->openaiRequest->model_requested = $this->model;
        $this->openaiRequest->input = $this->input;
        $this->openaiRequest->save();

        return $this->openaiRequest;
    }

    public function makeRequest(string $model, string $input): Response
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

            return $this->handleResponse($response);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse($response)
    {
        $json = $response->json();

        $this->openaiRequest->time = $this->measure();
        $this->openaiRequest->status = 'success';
        $this->openaiRequest->response_object = $json['object'];
        $this->openaiRequest->output = $json['data'];
        $this->openaiRequest->usage_prompt_tokens = $json['usage']['prompt_tokens'];
        $this->openaiRequest->usage_total_tokens = $json['usage']['total_tokens'];
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
