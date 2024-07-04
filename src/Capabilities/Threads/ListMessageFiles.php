<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessageFilesResponse;

class ListMessageFiles extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        string $messageId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ): MessageFilesResponse {
        $this->request->appendArgument('limit', $limit);
        $this->request->appendArgument('order', $order);
        $this->request->appendArgument('after', $after);
        $this->request->appendArgument('before', $before);

        $this->pending();

        try {
            $response = $this->openAI->http()->get("threads/{$threadId}/messages/{$messageId}/files", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

            return $this->handleResponse(new MessageFilesResponse($response), [$this, 'response']);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(MessageFilesResponse $response)
    {
        $this->request->output = $response->files;
    }
}
