<?php

namespace Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class VectorStoreDeleteResponse extends Response
{
    public string $id;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('deleted', $this->data['deleted']);
    }
}
