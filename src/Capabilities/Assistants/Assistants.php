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
        return (new CreateAssistant($this->openAI))->makeRequest(
            $model,
            $name,
            $description,
            $instructions,
            $tools,
            $fileIds,
            $metadata,
        );
    }
}
