<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonSchema implements Arrayable
{
    use StaticMake;

    public function __construct(protected array|Arrayable $schema, protected bool $strict = true, protected string $name = 'schema', protected ?string $description = null)
    {
        $this->schema = $schema instanceof Arrayable ? $schema->toArray() : $schema;
    }

    public function toArray(): array
    {
        $return = [
            'name' => $this->name,
            'strict' => $this->strict,
            'schema' => $this->schema,
        ];

        if ($this->description) {
            $return['description'] = $this->description;
        }

        return $return;
    }
}
