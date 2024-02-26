<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Illuminate\Http\Client\PendingRequest;
use Outl1ne\NovaOpenAI\Pricing\Pricing;

class Capability
{
    public function __construct(
        protected readonly PendingRequest $http,
        protected readonly Pricing $pricing,
    ) {
    }
}
