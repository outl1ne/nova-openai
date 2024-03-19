<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessageFileResponse;

class RetrieveMessageFile extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        string $messageId,
        string $fileId,
    ): MessageFileResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post("threads/{$threadId}/messages{$messageId}/files/{$fileId}", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new MessageFileResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
