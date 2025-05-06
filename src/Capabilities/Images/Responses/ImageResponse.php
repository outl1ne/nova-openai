<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Images\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class ImageResponse extends Response
{
    public array $images;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->images = array_map(fn ($item) => ImageData::from($item), $this->data['data']);
        $this->appendMeta('created', $this->data['created']);
        $this->appendMeta('data', $this->data['data']);
    }

    public static function from(array $response): self
    {
        return new self(
            created: $response['created'],
            data: array_map(fn ($item) => ImageData::from($item), $response['data']),
            usage: $response['usage'] ?? null,
        );
    }
}
