<?php

namespace Outl1ne\NovaOpenAI;

class NovaOpenAIConfig
{
    protected static $resourceMap = [
        'openai_request' => \Outl1ne\NovaOpenAI\Nova\OpenAIRequest::class,
    ];

    protected static $enumMap = [
        'openai_request_method' => \Outl1ne\NovaOpenAI\Enums\OpenAIRequestMethod::class,
        'openai_request_status' => \Outl1ne\NovaOpenAI\Enums\OpenAIRequestStatus::class,
    ];

    public static function resource($resourceName)
    {
        return config('nova-openai.resources.'.$resourceName, self::$resourceMap[$resourceName]);
    }

    public static function enum($enumName)
    {
        return config('nova-ecommerce.enums.'.$enumName, self::$enumMap[$enumName]);
    }
}
