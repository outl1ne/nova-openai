<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileResponse;

class UploadFile extends CapabilityClient
{
    protected string $method = 'files';

    public function makeRequest(
        $file,
        string $filename,
        string $purpose,
    ): FileResponse {
        $this->request->appendArgument('purpose', $purpose);

        $this->pending();

        try {
            $response = $this->openAI->http()->attach(
                'file',
                $file,
                $filename,
            )->post("files", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new FileResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
