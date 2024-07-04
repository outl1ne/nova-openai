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
            $response = $this->openAI->http()->delete("assistants/{$assistantId}/files/{$fileId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            return $this->handleResponse(new DeleteResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
