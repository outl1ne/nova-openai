<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonInteger implements Arrayable
{
    use StaticMake;

    public function __construct(protected ?string $description = null) {}

    public function toArray(): array
    {
        $return = [
            'type' => 'integer',
        ];

        if ($this->description) {
            $return['description'] = $this->description;
        }

        return $return;
    }
}
