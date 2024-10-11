<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreListResponse;

class ListVectorStores extends CapabilityClient
{
    protected string $method = 'vector_stores';

    public function makeRequest(
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ): VectorStoreListResponse {
        $this->request->appendArgument('limit', $limit);
        $this->request->appendArgument('order', $order);
        $this->request->appendArgument('after', $after);
        $this->request->appendArgument('before', $before);

        $this->pending();

        try {
            $response = $this->openAI->http()->get("vector_stores", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

            return $this->handleResponse(new VectorStoreListResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
