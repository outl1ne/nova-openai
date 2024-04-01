<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantFileResponse;

class CreateAssistantFile extends CapabilityClient
{
    protected string $method = 'assistants';

    public function makeRequest(
        string $assistantId,
        string $fileId,
    ): AssistantFileResponse {
        $this->request->appendArgument('file_id', $fileId);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post("assistants/{$assistantId}/files", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new AssistantFileResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
