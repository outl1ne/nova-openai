<?php

namespace Outl1ne\NovaOpenAI\Cache;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

interface CacheInterface
{
    public function get(array $arguments, callable $callback);
    public function put(array $arguments, Response $result);
}
