<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonNumber implements Arrayable
{
    use StaticMake;

    public function __construct(protected ?string $description = null, protected ?array $enum = null) {}

    public function toArray(): array
    {
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
