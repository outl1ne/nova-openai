<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadResponse;

class RetrieveThread extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
    ): ThreadResponse {
        $this->request->appendArgument('thread_id', $threadId);

        $this->pending();

        try {
            $response = $this->openAI->http()->get("threads/{$threadId}");

            return $this->handleResponse(new ThreadResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
