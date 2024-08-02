<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantResponse;

class ModifyAssistant extends CapabilityClient
{
    protected string $method = 'assistants';

    public function makeRequest(
        string $assistantId,
        ?string $model = null,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $toolResources = null,
        ?array $metadata = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?ResponseFormat $responseFormat = null,
    ): AssistantResponse {
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('name', $name);
        $this->request->appendArgument('description', $description);
        $this->request->appendArgument('instructions', $instructions);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('tool_resources', $toolResources);
        $this->request->appendArgument('metadata', $metadata);
        $this->request->appendArgument('temperature', $temperature);
        $this->request->appendArgument('top_p', $topP);
        $this->request->appendArgument('response_format', $responseFormat);

        $this->pending();

        try {
            $response = $this->openAI->http()->post("assistants/{$assistantId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new AssistantResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
