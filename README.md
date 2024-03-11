# Nova OpenAI

OpenAI SDK for a Laravel application that also stores OpenAI communication and presents it in a Laravel Nova admin panel.

This is currently an **unstable** package, breaking changes are to be expected. The main objective at the moment is to make it easier to include it as a dependency in our own client projects. This way we can make it more mature and have a v1 release when we feel it suits our needs in practice. This is why we haven't implemented all OpenAI endpoints yet and will add them one-by-one when they are actually needed.

If you need any features to be implemented or bump its priority in our backlog then feel free to make an inquiry via email at info@outl1ne.com.

## Screenshots

![Screenshot](resources/media/screenshot1.png)

## Requirements

- `php: >=8.1`
- `laravel/nova: ^4.0`

## Installation

```bash
# Install nova-openai
composer require outl1ne/nova-openai

# Run migrations
php artisan migrate

# Publish config file (optional)
php artisan vendor:publish --tag=nova-openai-config
```

Register the tool with Nova in the `tools()` method of the `NovaServiceProvider`:

```php
// in app/Providers/NovaServiceProvider.php

public function tools()
{
    return [
        \Outl1ne\NovaOpenAI\NovaOpenAI::make(),
    ];
}
```

## Usage

```php
$response = OpenAI::chat()->create(
    model: 'gpt-3.5-turbo',
    messages: (new Messages)->system('You are a helpful assistant.')->user('Hello!'),
);

$response = OpenAI::embeddings()->create(
    'text-embedding-3-small',
    'The food was delicious and the waiter...'
);
```

## Testing

You can use the `OpenAIRequest` factory to create a request for testing purposes.

```php
$mockOpenAIChat = Mockery::mock(Chat::class);
$mockOpenAIChat->shouldReceive('create')->andReturn((object) [
    'choices' => [
        [
            'message' => [
                'content' => 'Mocked response'
            ]
        ]
    ],
    'request' => OpenAIRequest::factory()->create()
]);
OpenAI::shouldReceive('chat')->andReturn($mockOpenAIChat);
```

## Contributing

```
composer install
testbench workbench:build
testbench serve
```
