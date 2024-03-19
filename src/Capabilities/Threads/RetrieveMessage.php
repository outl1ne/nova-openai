<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessageResponse;

class RetrieveMessage extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        string $messageId,
    ): MessageResponse {

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->get("threads/{$threadId}/messages/{$messageId}", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new MessageResponse($response), [$this, 'response']);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(MessageResponse $response)
    {
        $this->request->output = $response->content;
    }
}
