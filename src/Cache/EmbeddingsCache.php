<?php

namespace Outl1ne\NovaOpenAI\Cache;

use Illuminate\Support\Facades\Cache;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\EmbeddingsResponse;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\CachedEmbeddingsResponse;

class EmbeddingsCache implements CacheInterface
{
    public function __construct(readonly bool $enabled)
    {
    }

    public function get(array $arguments, callable $callback)
    {
        if (!$this->enabled) return $callback($arguments);

        $cache = Cache::get($this->cacheKey($arguments['model'], $arguments['input'], $arguments));

        if ($cache) {
            return new CachedEmbeddingsResponse($cache['embedding']);
        };

        return $callback($arguments);
    }

    public function put(array $arguments, Response $result)
    {
        if (!$result instanceof EmbeddingsResponse) return;
        if (!$this->enabled) return;

        Cache::put($this->cacheKey($arguments['model'], $arguments['input'], $arguments), [
            ...$arguments,
            'embedding' => $result->embedding,
        ]);
    }

    protected function cacheKey(string $model, string $input, array $arguments): string
    {
        $contentHash = hash('xxh3', $input);
        $argumentsHash = hash('xxh3', json_encode($arguments));

        return "embedding.{$model}.{$contentHash}.{$argumentsHash}";
    }
}
