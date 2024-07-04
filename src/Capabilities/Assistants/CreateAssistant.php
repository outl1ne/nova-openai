<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantResponse;

class CreateAssistant extends CapabilityClient
{
    protected string $method = 'assistants';

    public function makeRequest(
        string $model,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $fileIds = null,
        ?array $metadata = null,
    ): AssistantResponse {
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('name', $name);
        $this->request->appendArgument('description', $description);
        $this->request->appendArgument('instructions', $instructions);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('file_ids', $fileIds);
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->post("assistants", [
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
