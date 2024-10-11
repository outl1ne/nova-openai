<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreResponse;

class RetrieveVectorStore extends CapabilityClient
{
    protected string $method = 'vector_stores';

    public function makeRequest(
        string $vectorStoreId,
    ): VectorStoreResponse {
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
