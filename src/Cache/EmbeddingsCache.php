<?php

namespace Outl1ne\NovaOpenAI\Cache;

use Illuminate\Support\Facades\Cache;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\CachedEmbeddingsResponse;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\EmbeddingsResponse;

class EmbeddingsCache
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

    public function put(array $arguments, EmbeddingsResponse $result)
    {
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
