<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings;

use Exception;
use Outl1ne\NovaOpenAI\Pricing\Calculator;
use Outl1ne\NovaOpenAI\Capabilities\Capability;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\EmbeddingsResponse;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\CachedEmbeddingsResponse;

class CreateEmbedding extends CapabilityClient
{
    protected string $method = 'embeddings';
    public readonly Capability $capability;

    public function __construct(Embeddings $capability)
    {
        parent::__construct($capability);
    }

    public function makeRequest(string $model, string $input, ?string $encodingFormat = null, ?int $dimensions = null, ?string $user = null): EmbeddingsResponse|CachedEmbeddingsResponse
    {
        $this->request->model_requested = $model;
        $this->request->input = $input;
        $this->request->appendArgument('encoding_format', $encodingFormat);
        $this->request->appendArgument('dimensions', $dimensions);
        $this->request->appendArgument('user', $user);

        $this->pending();

        try {
            $response = $this->capability->cache->get([
                'model' => $model,
                'input' => $input,
                ...$this->request->arguments,
            ], fn ($args) => $this->openAI->http()->post('embeddings', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($args),
            ]));

            if ($response instanceof CachedEmbeddingsResponse) {
                return $this->handleCachedResponse($response, [$this, 'cachedResponse']);
            } else {
                $result = $this->handleResponse(new EmbeddingsResponse($response), [$this, 'response']);

                $this->capability->cache->put([
                    'model' => $model,
                    'input' => $input,
                    ...$this->request->arguments,
                ], $result);

                return $result;
            }
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(EmbeddingsResponse $response)
    {
        $this->request->output = $response->embedding;
    }

    protected function cachedResponse(CachedEmbeddingsResponse $response)
    {
        $this->request->output = $response->embedding;
    }

    protected function pricing(): Calculator
    {
        return $this->openAI->pricing->embedding();
    }
}
