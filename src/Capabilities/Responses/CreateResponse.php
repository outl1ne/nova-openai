<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Responses\ResponsesResponse;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Responses\StreamedResponsesResponse;

class CreateResponse extends CapabilityClient
{
    protected string $method = 'responses';

    public function makeRequest(
        string $model,
        string|array $input,
        ?string $instructions = null,
        ?string $previousResponseId = null,
        ?array $tools = null,
        ?string $toolChoice = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?int $maxOutputTokens = null,
        ?bool $parallelToolCalls = null,
        ?string $user = null,
        ?array $metadata = null,
        ?bool $store = null,
        ?bool $background = null,
        ?string $reasoningEffort = null,
        ?array $reasoning = null,
        ?array $text = null,
        ?string $truncation = null,
        ?array $include = null,
        ?bool $stream = null,
        ?string $requestName = null
    ) {
        $this->request->model_requested = $model;
        $this->request->input = ['instructions' => $instructions, 'input' => $input];
        $this->request->name = $requestName;

        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('input', $input);
        $this->request->appendArgument('instructions', $instructions);
        $this->request->appendArgument('previous_response_id', $previousResponseId);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('tool_choice', $toolChoice);
        $this->request->appendArgument('temperature', $temperature);
        $this->request->appendArgument('top_p', $topP);
        $this->request->appendArgument('max_output_tokens', $maxOutputTokens);
        $this->request->appendArgument('parallel_tool_calls', $parallelToolCalls);
        $this->request->appendArgument('user', $user);
        $this->request->appendArgument('metadata', $metadata);
        $this->request->appendArgument('store', $store);
        $this->request->appendArgument('background', $background);
        $this->request->appendArgument('text', $text);
        $this->request->appendArgument('truncation', $truncation);
        $this->request->appendArgument('include', $include);
        $this->request->appendArgument('stream', $stream);

        // Handle reasoning parameters - can be either reasoningEffort string or reasoning object
        if ($reasoning !== null) {
            $this->request->appendArgument('reasoning', $reasoning);
        } elseif ($reasoningEffort !== null) {
            $this->request->appendArgument('reasoning', ['effort' => $reasoningEffort]);
        }

        $this->pending();

        try {
            $response = $this->openAI->http()->post('responses', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new ResponsesResponse($response), [$this, 'response']);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(ResponsesResponse|StreamedResponsesResponse $response)
    {
        $this->request->output = $response->output;
    }
}
