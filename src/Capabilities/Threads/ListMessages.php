<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessagesResponse;

class ListMessages extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ): MessagesResponse {
        $this->request->appendArgument('limit', $limit);
        $this->request->appendArgument('order', $order);
        $this->request->appendArgument('after', $after);
        $this->request->appendArgument('before', $before);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->get("threads/{$threadId}/messages", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new MessagesResponse($response), [$this, 'response']);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(MessagesResponse $response)
    {
        $this->request->output = $response->messages;
    }
}
