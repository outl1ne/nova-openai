<?php

namespace Outl1ne\NovaOpenAI\Resources;

use Outl1ne\NovaOpenAI\Http;

class Resource
{
    public function __construct(
        protected readonly Http $http,
    ) {}
}
