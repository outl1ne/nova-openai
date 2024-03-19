<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\RunResponse;

class CreateRun extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        string $assistantId,
        ?string $model = null,
        ?string $instructions = null,
        ?string $additionalInstructions = null,
        ?array $tools = null,
        ?array $metadata = null,
    ): RunResponse {
        $this->request->model_requested = $model;
        $this->request->appendArgument('assistant_id', $assistantId);
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('instructions', $instructions);
        $this->request->appendArgument('additional_instructions', $additionalInstructions);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post("threads/{$threadId}/runs", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new RunResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
