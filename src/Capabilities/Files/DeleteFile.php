<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\DeleteResponse;

class DeleteFile extends CapabilityClient
{
    protected string $method = 'files';

    public function makeRequest(
        string $fileId,
    ): DeleteResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->delete("files/{$fileId}", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new DeleteResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
