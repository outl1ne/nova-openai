<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Outl1ne\NovaOpenAI\Capabilities\Capability;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages;

class Threads extends Capability
{
    public function create(
        ?Messages $messages = null,
        ?array $metadata = null,
    ) {
        return (new CreateThread($this->openAI))->makeRequest(
            $messages,
            $metadata
        );
    }

    public function retrieve(
        string $threadId,
    ) {
        return (new RetrieveThread($this->openAI))->makeRequest(
            $threadId,
        );
    }
}
