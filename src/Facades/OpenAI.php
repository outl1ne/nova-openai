<?php

namespace Outl1ne\NovaOpenAI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \OpenAI\Resources\Embeddings\Embeddings embeddings()
 */
final class OpenAI extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'nova-openai';
    }
}
