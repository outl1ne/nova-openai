<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Default HTTP headers
    |--------------------------------------------------------------------------
    |
    | HTTP headers to be added to the requests made against OpenAI API.
    */

    'headers' => [
        'OpenAI-Beta' => 'assistants=v2',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pricing configuration
    |--------------------------------------------------------------------------
    |
    | Path to the pricing configuration file to be used to calculate
    | the cost of requests made against OpenAI API.
    */

    'pricing' => null,

    /*
    |--------------------------------------------------------------------------
    | Embeddings cache
    |--------------------------------------------------------------------------
    |
    | Cache embedding responses to reduce the cost for duplicate requests.
    */

    'cache_embeddings' => env('OPENAI_CACHE_EMBEDDINGS', false),
];
