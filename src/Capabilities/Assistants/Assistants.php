<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class Assistants extends Capability
{
    public function create(
        string $model,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $fileIds = null,
        ?array $metadata = null,
    ) {
        return (new CreateAssistant($this))->makeRequest(
            $model,
            $name,
            $description,
            $instructions,
            $tools,
            $fileIds,
            $metadata,
        );
    }

    public function modify(
        string $assistantId,
        ?string $model = null,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $fileIds = null,
        ?array $metadata = null,
    ) {
        return (new ModifyAssistant($this))->makeRequest(
            $assistantId,
            $model,
            $name,
            $description,
            $instructions,
            $tools,
            $fileIds,
            $metadata,
        );
    }

    public function delete(
        string $assistantId,
    ) {
        return (new DeleteAssistant($this))->makeRequest(
            $assistantId,
        );
    }

    public function files(): AssistantFiles
    {
        return new AssistantFiles($this->openAI);
    }
}
