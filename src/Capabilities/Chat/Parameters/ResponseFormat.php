<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters;

use Outl1ne\NovaOpenAI\Traits\StaticMake;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\Arrayable;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonSchema;

class ResponseFormat
{
    use StaticMake;

    public ?array $responseFormat = null;

    public function text(): self
    {
        $this->responseFormat = [
            'type' => 'text',
        ];
        return $this;
    }

    public function json(): self
    {
        $this->responseFormat = [
            'type' => 'json_object',
        ];
        return $this;
    }

    public function jsonSchema(array|Arrayable $schema): self
    {
        $this->responseFormat = [
            'type' => 'json_schema',
            'json_schema' => $schema instanceof Arrayable ? (new JsonSchema($schema))->toArray() : $schema,
        ];
        return $this;
    }
}
