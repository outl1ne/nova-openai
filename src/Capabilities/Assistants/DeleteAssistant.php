<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\DeleteResponse;

class DeleteAssistant extends CapabilityClient
{
    protected string $method = 'assistants';

    public function makeRequest(
        string $assistantId,
    ): DeleteResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->delete("assistants/{$assistantId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new DeleteResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
