<?php

namespace Outl1ne\NovaOpenAI;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http as LaravelHttp;

class Http
{
    public function __construct(
        protected readonly string $baseUrl,
        protected readonly array $headers,
    ) {
        // ..
    }

    public function client(): PendingRequest
    {
        return LaravelHttp::baseUrl($this->baseUrl)->withHeaders($this->headers);
    }
}
