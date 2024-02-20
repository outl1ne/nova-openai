<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

trait AppendsMeta
{
    public array $meta;

    protected function appendMeta(string $key, $value)
    {
        if ($value === null) {
            return false;
        }

        $this->meta = [
            ...$this->meta ?? [],
            $key => $value,
        ];

        return true;
    }
}
