# Nova OpenAI

OpenAI SDK for a Laravel application that also stores OpenAI communication and presents it in a Laravel Nova admin panel.

This is currently an **unstable** package, breaking changes are to be expected. The main objective at the moment is to make it easier to include it as a dependency in our own client projects. This way we can make it more mature and have a v1 release when we feel it suits our needs in practice. This is why we haven't implemented all OpenAI endpoints yet and will add them one-by-one when they are actually needed.

If you need any features to be implemented or bump its priority in our backlog then feel free to make an inquiry via email at info@outl1ne.com.

## Requirements

- `php: >=8.1`
- `laravel/nova: ^4.0`

## Installation

```bash
composer require outl1ne/nova-openai

// optional
php artisan vendor:publish --tag=nova-openai-config
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

## Contributing

```
composer install
testbench workbench:build
testbench serve
```
