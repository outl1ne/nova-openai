<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonNumber implements Arrayable
{
    use StaticMake;

    public function __construct(protected ?string $description = null) {}

    public function toArray(): array
    {
        $return = [
            'type' => 'number',
        ];

        if ($this->description) {
            $return['description'] = $this->description;
        }

        return $return;
    }
}
