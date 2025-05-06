<?php

namespace Outl1ne\NovaOpenAI;

use Closure;
use GuzzleHttp\Client;
use Outl1ne\NovaOpenAI\Pricing\Pricing;
use Outl1ne\NovaOpenAI\Cache\EmbeddingsCache;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Chat;
use Outl1ne\NovaOpenAI\Capabilities\Files\Files;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Threads;
use Outl1ne\NovaOpenAI\Capabilities\Images\Images;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Assistants;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Embeddings;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\VectorStores;

class OpenAI
{
    public readonly Closure $http;
    public readonly Pricing $pricing;

    public function __construct(
        protected readonly string $baseUrl,
        protected readonly array $headers,
        protected int $timeout,
        ?object $pricing = null,
        protected bool $cacheEmbeddings = false,
    ) {
        $this->pricing = new Pricing($pricing);
    }

    public function embeddings(): Embeddings
    {
        $embeddings = new Embeddings($this);
        $embeddings->setCache(new EmbeddingsCache($this->cacheEmbeddings));
        return $embeddings;
    }

    public function chat(): Chat
    {
        return new Chat($this);
    }

    public function assistants(): Assistants
    {
        return new Assistants($this);
    }

    public function threads(): Threads
    {
        return new Threads($this);
    }

    public function files(): Files
    {
        return new Files($this);
    }

    public function vectorStores(): VectorStores
    {
        return new VectorStores($this);
    }

    public function images(): Images
    {
        return new Images($this);
    }

    public function json(string $response): ?object
    {
        return Helpers::json($response);
    }

    public function http(): Client
    {
        return new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => $this->headers,
        ]);
    }
}
