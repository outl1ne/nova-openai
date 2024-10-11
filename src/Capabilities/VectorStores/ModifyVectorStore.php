<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreResponse;

class ModifyVectorStore extends CapabilityClient
{
    protected string $method = 'vector_stores';

    public function makeRequest(
        string $vectorStoreId,
        ?string $name = null,
        ?array $expiresAfter = null,
        ?array $metadata = null,
    ): VectorStoreResponse {
        $this->request->appendArgument('name', $name);
        $this->request->appendArgument('expires_after', $expiresAfter);
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->post("vector_stores/{$vectorStoreId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new VectorStoreResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
