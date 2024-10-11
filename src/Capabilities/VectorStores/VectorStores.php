<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class VectorStores extends Capability
{
    public function create(
        ?array $fileIds = null,
        ?string $name = null,
        ?array $expiresAfter = null,
        ?array $chunkingStrategy = null,
        ?array $metadata = null,
    ) {
        return (new CreateVectorStore($this))->makeRequest(
            $fileIds,
            $name,
            $expiresAfter,
            $chunkingStrategy,
            $metadata,
        );
    }

    public function list(
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ) {
        return (new ListVectorStores($this))->makeRequest(
            $limit,
            $order,
            $after,
            $before,
        );
    }

    public function retrieve(
        string $vectorStoreId,
    ) {
        return (new RetrieveVectorStore($this))->makeRequest(
            $vectorStoreId,
        );
    }

    public function modify(
        string $vectorStoreId,
        ?string $name = null,
        ?array $expiresAfter = null,
        ?array $metadata = null,
    ) {
        return (new ModifyVectorStore($this))->makeRequest(
            $vectorStoreId,
            $name,
            $expiresAfter,
            $metadata,
        );
    }

    public function delete(
        string $vectorStoreId,
    ) {
        return (new DeleteVectorStore($this))->makeRequest(
            $vectorStoreId,
        );
    }
}
