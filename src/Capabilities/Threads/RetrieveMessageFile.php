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
            $response = $this->openAI->http()->get("threads/{$threadId}/messages{$messageId}/files/{$fileId}", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

            return $this->handleResponse(new MessageFileResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
