<?php

namespace Outl1ne\NovaOpenAI;

class NovaOpenAIConfig
{
    protected static $resourceMap = [
        'openai_request' => \Outl1ne\NovaOpenAI\Nova\OpenAIRequest::class,
    ];

    public static function resource($resourceName)
    {
        return config('nova-openai.resources.' . $resourceName, self::$resourceMap[$resourceName]);
    }
}
