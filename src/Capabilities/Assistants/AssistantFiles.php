<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class AssistantFiles extends Capability
{
    public function create(
        string $assistantId,
        string $fileId,
    ) {
        return (new CreateAssistantFile($this))->makeRequest(
            $assistantId,
            $fileId,
        );
    }

    public function list(
        string $assistantId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ) {
        return (new ListAssistantFiles($this))->makeRequest(
            $assistantId,
            $limit,
            $order,
            $after,
            $before,
        );
    }

    public function delete(
        string $assistantId,
        string $fileId,
    ) {
        return (new DeleteAssistantFile($this))->makeRequest(
            $assistantId,
            $fileId,
        );
    }
}
