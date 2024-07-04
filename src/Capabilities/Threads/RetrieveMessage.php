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
            $response = $this->openAI->http()->get("threads/{$threadId}/messages/{$messageId}", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

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
