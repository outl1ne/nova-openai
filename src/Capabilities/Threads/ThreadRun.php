<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class ThreadRun extends Capability
{
    public function execute(
        string $threadId,
        string $assistantId,
        ?string $model = null,
        ?string $instructions = null,
        ?string $additionalInstructions = null,
        ?array $tools = null,
        ?array $metadata = null,
    ) {
        return (new CreateRun($this->openAI))->makeRequest(
            $threadId,
            $assistantId,
            $model,
            $instructions,
            $additionalInstructions,
            $tools,
            $metadata,
        );
    }

    public function retrieve(
        string $threadId,
        string $runId,
    ) {
        return (new RetrieveRun($this->openAI))->makeRequest(
            $threadId,
            $runId,
        );
    }
}
