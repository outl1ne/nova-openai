<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileDeleteResponse;

class DeleteFile extends CapabilityClient
{
    protected string $method = 'files';

    public function makeRequest(
        string $fileId,
    ): FileDeleteResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->delete("files/{$fileId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new FileDeleteResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
