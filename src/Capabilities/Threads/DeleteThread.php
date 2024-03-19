<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadDeletionStatusResponse;

class DeleteThread extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
    ): ThreadDeletionStatusResponse {

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->delete("threads/{$threadId}", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new ThreadDeletionStatusResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
