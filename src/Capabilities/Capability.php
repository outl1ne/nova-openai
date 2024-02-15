<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Illuminate\Http\Client\PendingRequest;

class Capability
{
    public function __construct(
        protected readonly PendingRequest $http,
    ) {
    }
}
