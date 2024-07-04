<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Message;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessageResponse;

class CreateMessage extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        Message $message,
    ): MessageResponse {
        $this->request->appendArgument('role', $message->role);
        $this->request->appendArgument('content', $message->content);
        $this->request->appendArgument('file_ids', $message->fileIds);
        $this->request->appendArgument('metadata', $message->metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->post("threads/{$threadId}/messages", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
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
