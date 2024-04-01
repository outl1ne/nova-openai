<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\DeleteResponse;

class DeleteAssistantFile extends CapabilityClient
{
    protected string $method = 'assistants';

    public function makeRequest(
        string $assistantId,
        string $fileId,
    ): DeleteResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->delete("assistants/{$assistantId}/files/{$fileId}");
            $response->throw();

            return $this->handleResponse(new DeleteResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
