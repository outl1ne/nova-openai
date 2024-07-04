<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\RunResponse;

class RetrieveRun extends CapabilityClient
{
    protected string $method = 'threads';

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->capability->shouldStorePending(fn () => false);
        $this->capability->shouldStore(fn ($response = null) => $response?->meta['status'] !== 'in_progress');
    }

    public function makeRequest(
        string $threadId,
        string $runId,
    ): RunResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->get("threads/{$threadId}/runs/{$runId}", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

            return $this->handleResponse(new RunResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
