<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonAnyOf implements Arrayable
{
    use StaticMake;

    protected array $schemas = [];

    public function schema(array|Arrayable $schema): self
    {
        $this->schemas[] = $schema instanceof Arrayable ? $schema->toArray() : $schema;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'anyOf' => $this->schemas,
        ];
    }
}
