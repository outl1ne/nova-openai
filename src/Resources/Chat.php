<?php

namespace Outl1ne\NovaOpenAI\Resources;

use Exception;
use OpenAI\Client;
use OpenAI\Responses\StreamResponse;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Contracts\Resources\ChatContract;
use Outl1ne\NovaOpenAI\Models\OpenaiRequest;

class Chat implements ChatContract
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
        $openaiRequest->method = 'chat';
        $openaiRequest->status = 'pending';
        $openaiRequest->model_requested = $parameters[0]['model'] ?? null;
        $openaiRequest->input = $parameters[0]['messages'] ?? null;
        $openaiRequest->save();

        try {
            $response = $this->openAI->chat()->create(...$parameters);

            $time = microtime(true) - $start;
            $openaiRequest->time = $time;
            $openaiRequest->status = 'success';
            $openaiRequest->model_used = $response->model;
            $openaiRequest->response_id = $response->id;
            $openaiRequest->response_object = $response->object;
            $openaiRequest->response_created = $response->created;
            $openaiRequest->response_system_fingerprint = $response->systemFingerprint;
            $openaiRequest->output = $response->choices;
            $openaiRequest->usage_prompt_tokens = $response->usage->promptTokens;
            $openaiRequest->usage_completion_tokens = $response->usage->completionTokens;
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

    public function createStreamed(...$parameters): StreamResponse
    {
        return $this->openAI->chat()->createStreamed(...$parameters);
    }
}
