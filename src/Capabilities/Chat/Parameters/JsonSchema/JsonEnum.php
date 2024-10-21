<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Exception;
use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonEnum implements Arrayable
{
    use StaticMake;

    public function __construct(protected ?string $description = null, protected ?array $enum = null) {}

    public function enums(array $enum): self
    {
        $this->enum = $enum;
        return $this;
    }

    public function toArray(): array
    {
        if (!$this->enum) {
            throw new Exception('Enum values are required for JsonEnum');
        }

        $return = [
            'type' => 'string',
        ];

        if ($this->description) {
            $return['description'] = $this->description;
        }

        if ($this->enum) {
            $return['enum'] = $this->enum;
        }

        return $return;
    }
}
