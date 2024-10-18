<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class JsonArray implements Arrayable
{
    use StaticMake;

    protected array $items = [];

    public function __construct(protected ?string $description = null) {}

    public function items(array|Arrayable $itemSchema): self
    {
        $this->items = $itemSchema instanceof Arrayable ? $itemSchema->toArray() : $itemSchema;
        return $this;
    }

    public function toArray(): array
    {
        $return = [
            'type' => 'array',
            'items' => $this->items,
        ];

        if ($this->description) {
            $return['description'] = $this->description;
        }

        return $return;
    }
}
