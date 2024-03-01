<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Outl1ne\NovaOpenAI\OpenAI;

class Capability
{
    public function __construct(
        protected readonly OpenAI $openAI,
    ) {
    }
}
