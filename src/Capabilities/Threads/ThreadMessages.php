<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Outl1ne\NovaOpenAI\Capabilities\Capability;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Message;

class ThreadMessages extends Capability
{
    public function create(
        string $threadId,
        Message $messages,
    ) {
        return (new CreateMessage($this))->makeRequest(
            $threadId,
            $messages,
        );
    }

    public function list(
        string $threadId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ) {
        return (new ListMessages($this))->makeRequest(
            $threadId,
            $limit,
            $order,
            $after,
            $before
        );
    }

    public function listFiles(
        string $threadId,
        string $messageId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ) {
        return (new ListMessageFiles($this))->makeRequest(
            $threadId,
            $messageId,
            $limit,
            $order,
            $after,
            $before
        );
    }

    public function retrieve(
        string $threadId,
        string $messageId,
    ) {
        return (new RetrieveMessage($this))->makeRequest(
            $threadId,
            $messageId,
        );
    }

    public function retrieveFile(
        string $threadId,
        string $messageId,
        string $fileId,
    ) {
        return (new RetrieveMessageFile($this))->makeRequest(
            $threadId,
            $messageId,
            $fileId,
        );
    }

    public function modify(
        string $threadId,
        string $messageId,
        ?array $metadata = null,
    ) {
        return (new ModifyMessage($this))->makeRequest(
            $threadId,
            $messageId,
            $metadata,
        );
    }
}
