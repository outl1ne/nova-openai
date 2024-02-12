<?php

namespace Outl1ne\NovaOpenAI\Resources;

use Illuminate\Http\Client\PendingRequest;

class Resource
{
    public function __construct(
        protected readonly PendingRequest $http,
    ) {
    }
}
