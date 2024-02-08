<?php

namespace Outl1ne\NovaOpenAI\Resources;

class Usage
{
    public function __construct(public readonly int $promptTokens, public readonly ?int $completionTokens, public readonly int $totalTokens) {}
}
