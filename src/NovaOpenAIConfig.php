<?php

namespace Outl1ne\NovaOpenAI;

class NovaOpenAIConfig
{
    protected static $resourceMap = [
    ];

    public static function resource($resourceName)
    {
        return config('nova-openai.resources.'.$resourceName, self::$resourceMap[$resourceName]);
    }
}
