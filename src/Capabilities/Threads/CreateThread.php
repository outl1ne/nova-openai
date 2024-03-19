<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadResponse;

class CreateThread extends CapabilityClient
{
    protected string $method = 'threads';

    public function makeRequest(
        ?Messages $messages,
        ?array $metadata,
    ): ThreadResponse {
        $this->request->input = $messages->messages ?? null;
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post('threads', [
                'messages' => $messages->messages ?? null,
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new ThreadResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
