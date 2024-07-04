<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadResponse;

class ModifyThread extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        string $threadId,
        ?array $metadata = null,
    ): ThreadResponse {
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->post("threads/{$threadId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new ThreadResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
