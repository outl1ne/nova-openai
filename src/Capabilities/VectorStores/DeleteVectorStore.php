<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreDeleteResponse;

class DeleteVectorStore extends CapabilityClient
{
    protected string $method = 'vector_stores';

    public function makeRequest(
        string $vectorStoreId,
    ): VectorStoreDeleteResponse {
        $this->pending();

        try {
            $response = $this->openAI->http()->delete("vector_stores/{$vectorStoreId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    ...$this->request->arguments,
                ]),
            ]);

            return $this->handleResponse(new VectorStoreDeleteResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
