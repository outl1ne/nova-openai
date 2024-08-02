<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Outl1ne\NovaOpenAI\Capabilities\Capability;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;

class Assistants extends Capability
{
    public function create(
        string $model,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $toolResources = null,
        ?array $metadata = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?ResponseFormat $responseFormat = null,
    ) {
        return (new CreateAssistant($this))->makeRequest(
            $model,
            $name,
            $description,
            $instructions,
            $tools,
            $toolResources,
            $metadata,
            $temperature,
            $topP,
            $responseFormat,
        );
    }

    public function modify(
        string $assistantId,
        ?string $model = null,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $toolResources = null,
        ?array $metadata = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?ResponseFormat $responseFormat = null,
    ) {
        return (new ModifyAssistant($this))->makeRequest(
            $assistantId,
            $model,
            $name,
            $description,
            $instructions,
            $tools,
            $toolResources,
            $metadata,
            $temperature,
            $topP,
            $responseFormat,
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
