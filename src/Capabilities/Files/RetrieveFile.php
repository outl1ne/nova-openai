<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileResponse;

class RetrieveFile extends CapabilityClient
{
    protected string $method = 'files';

    public function makeRequest(
        string $fileId,
    ): FileResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->get("files/{$fileId}", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new FileResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
