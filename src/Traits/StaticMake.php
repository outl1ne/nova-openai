<?php

namespace Outl1ne\NovaOpenAI\Traits;

trait StaticMake
{
    static public function make(...$arguments): self
    {
        return new self(...$arguments);
    }
}
