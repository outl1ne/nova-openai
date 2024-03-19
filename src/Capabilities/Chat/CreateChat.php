<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\ChatResponse;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;

class CreateChat extends CapabilityClient
{
    protected string $method = 'chat';

    public function makeRequest(
        string $model,
        Messages $messages,
        ?ResponseFormat $responseFormat = null,
        ?string $user = null,
        ?float $frequencyPenalty = null,
        ?array $logitBias = null,
        ?bool $logprobs = null,
        ?int $topLogprobs = null,
        ?int $maxTokens = null,
        ?int $n = null,
        ?float $presencePenalty = null,
        ?int $seed = null,
        null|string|array $stop = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?array $tools = null,
        null|string|array $toolChoice = null,
    ): ChatResponse {
        $this->request->model_requested = $model;
        $this->request->input = $messages->messages;
        $this->request->appendArgument('response_format', $responseFormat);
        $this->request->appendArgument('user', $user);
        $this->request->appendArgument('frequency_penalty', $frequencyPenalty);
        $this->request->appendArgument('logit_bias', $logitBias);
        $this->request->appendArgument('logprobs', $logprobs);
        $this->request->appendArgument('top_logprobs', $topLogprobs);
        $this->request->appendArgument('max_tokens', $maxTokens);
        $this->request->appendArgument('n', $n);
        $this->request->appendArgument('presence_penalty', $presencePenalty);
        $this->request->appendArgument('seed', $seed);
        $this->request->appendArgument('stop', $stop);
        $this->request->appendArgument('temperature', $temperature);
        $this->request->appendArgument('top_p', $topP);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('tool_choice', $toolChoice);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post('chat/completions', [
                'model' => $model,
                'messages' => $messages->messages,
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new ChatResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse(ChatResponse $response)
    {
        $this->request->cost = $this->openAI->pricing->models()->model($response->model)->calculate($response->usage->promptTokens, $response->usage->completionTokens);
        $this->request->time_sec = $this->measure();
        $this->request->status = 'success';
        $this->request->meta = $response->meta;
        $this->request->model_used = $response->model;
        $this->request->output = $response->choices;
        $this->request->usage_prompt_tokens = $response->usage->promptTokens;
        $this->request->usage_completion_tokens = $response->usage->completionTokens;
        $this->request->usage_total_tokens = $response->usage->totalTokens;
        $this->store($response);

        $response->request = $this->request;

        return $response;
    }
}
