<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class VectorStoreResponse extends Response
{
    public string $id;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('name', $this->data['name']);
        $this->appendMeta('status', $this->data['status']);
        $this->appendMeta('usage_bytes', $this->data['usage_bytes']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('file_counts', $this->data['file_counts']);
        $this->appendMeta('metadata', $this->data['metadata']);
        $this->appendMeta('expires_after', $this->data['expires_after']);
        $this->appendMeta('expires_at', $this->data['expires_at']);
        $this->appendMeta('last_active_at', $this->data['last_active_at']);
    }
}
