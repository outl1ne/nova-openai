<?php

namespace Outl1ne\NovaOpenAI\Resources;

use Exception;
use OpenAI\Client;
use Outl1ne\NovaOpenAI\Models\OpenaiRequest;
use OpenAI\Responses\Embeddings\CreateResponse;
use OpenAI\Contracts\Resources\EmbeddingsContract;

class Embeddings implements EmbeddingsContract
{
    protected $openAI;

    public function __construct(Client $openAI)
    {
        $this->openAI = $openAI;
    }

    public function create(...$parameters): CreateResponse
    {
        $start = microtime(true);

        $openaiRequest = new OpenaiRequest;
        $openaiRequest->method = 'embeddings';
        $openaiRequest->status = 'pending';
        $openaiRequest->model_requested = $parameters[0]['model'] ?? null;
        $openaiRequest->input = $parameters[0]['input'] ?? null;
        $openaiRequest->save();

        try {
            $response = $this->openAI->embeddings()->create(...$parameters);

            $time = microtime(true) - $start;
            $openaiRequest->time = $time;
            $openaiRequest->status = 'success';
            $openaiRequest->response_object = $response->object;
            $openaiRequest->output = $response->embeddings;
            $openaiRequest->usage_prompt_tokens = $response->usage->promptTokens;
            $openaiRequest->usage_total_tokens = $response->usage->totalTokens;
            $openaiRequest->save();

            return $response;
        } catch (Exception $e) {
            $time = microtime(true) - $start;
            $openaiRequest->time = $time;
            $openaiRequest->status = 'error';
            $openaiRequest->error = $e->getMessage();
            $openaiRequest->save();

            throw $e;
        }
        return null;
    }
}
