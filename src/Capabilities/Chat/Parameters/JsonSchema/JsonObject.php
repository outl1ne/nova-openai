<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonObject implements Arrayable
{
    use StaticMake;

    protected array $properties = [];

    public function __construct(protected ?string $description = null, protected bool $additionalProperties = false) {}

    public function property(string $name, array|Arrayable $schema): self
    {
        $this->properties[$name] = $schema instanceof Arrayable ? $schema->toArray() : $schema;
        return $this;
    }

    public function toArray(): array
    {
        $return = [
            'type' => 'object',
            'properties' => $this->properties,
            'additionalProperties' => $this->additionalProperties,
            'required' => array_keys($this->properties),
        ];

        if ($this->description) {
            $return['description'] = $this->description;
        }

        return $return;
    }
}
