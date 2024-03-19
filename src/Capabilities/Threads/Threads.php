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
        return (new CreateThread($this))->makeRequest(
            $messages,
            $metadata,
        );
    }

    public function retrieve(
        string $threadId,
    ) {
        return (new RetrieveThread($this))->makeRequest(
            $threadId,
        );
    }

    public function modify(
        string $threadId,
        ?array $metadata = null,
    ) {
        return (new ModifyThread($this))->makeRequest(
            $threadId,
            $metadata,
        );
    }

    public function delete(
        string $threadId,
    ) {
        return (new DeleteThread($this))->makeRequest(
            $threadId,
        );
    }

    public function messages(): ThreadMessages
    {
        return new ThreadMessages($this->openAI);
    }

    public function run(): ThreadRun
    {
        return new ThreadRun($this->openAI);
    }
}
