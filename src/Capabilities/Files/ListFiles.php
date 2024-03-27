<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileListResponse;

class ListFiles extends CapabilityClient
{
    protected string $method = 'files';

    public function makeRequest(
        ?string $purpose = null,
    ): FileListResponse {
        $this->request->appendArgument('purpose', $purpose);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->get("files", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new FileListResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
