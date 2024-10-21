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

### Assistants

```php
$assistant = OpenAI::assistants()->create(
  'gpt-3.5-turbo',
  'Allan\'s assistant',
  'For testing purposes of nova-openai package.',
  'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.'
);
$assistantModified = OpenAI::assistants()->modify($assistant->id, null, 'Allan\'s assistant!');
$deletedAssistant = OpenAI::assistants()->delete($assistant->id);
// dd($assistant->response->json(), $assistantModified->response->json(), $deletedAssistant->response->json());
```

Attaching, listing and deleting files.

```php
$assistant = OpenAI::assistants()->create(
    'gpt-3.5-turbo',
    'Allan\'s assistant',
    'For testing purposes of nova-openai package.',
    'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.',
    [
        [
            'type' => 'retrieval',
        ],
    ],
);
$file = OpenAI::files()->upload(
    file_get_contents('files/file.txt'),
    'file.txt',
    'assistants',
);
$assistantFile = OpenAI::assistants()->files()->create($assistant->id, $file->id);
$assistantFiles = OpenAI::assistants()->files()->list($assistant->id);
$deletedAssistantFile = OpenAI::assistants()->files()->delete($assistant->id, $file->id);

// Cleanup
$deletedAssistant = OpenAI::assistants()->delete($assistant->id);
$deletedFile = OpenAI::files()->delete($file->id);
// dd(
//     $assistantFile->response->json(),
//     $assistantFiles->response->json(),
//     $deletedAssistantFile->response->json(),
// );
```

### Chat

```php
$response = OpenAI::chat()->create(
    model: 'gpt-3.5-turbo',
    messages: Messages::make()->system('You are a helpful assistant.')->user('Hello!'),
)->json();
```

Enable JSON response formatting:

```php
$response = OpenAI::chat()->create(
    model: 'gpt-3.5-turbo',
    messages: Messages::make()->system('You are a helpful assistant.')->user('Suggest me tasty fruits as JSON array of fruits.'),
    responseFormat: ResponseFormat::make()->json(),
)->json();
```

JSON Structured Outputs example:

```php
$response = OpenAI::chat()->create(
    model: 'gpt-4o-mini',
    messages: Messages::make()->system('You are a helpful assistant.')->user('Suggest me 10 tasty fruits.'),
    responseFormat: ResponseFormat::make()->jsonSchema(
        JsonObject::make()
            ->property('fruits', JsonArray::make()->items(JsonString::make()))
            ->property('number_of_fruits_in_response', JsonInteger::make())
            ->property('number_of_fruits_in_response_divided_by_three', JsonNumber::make())
            ->property('is_number_of_fruits_in_response_even', JsonBoolean::make())
            ->property('fruit_most_occurring_color', JsonEnum::make()->enums(['red', 'green', 'blue']))
            ->property(
                'random_integer_or_string_max_one_character',
                JsonAnyOf::make()
                    ->schema(JsonInteger::make())
                    ->schema(JsonString::make())
            ),
    ),
)->json();
```

With raw JSON schema:

```php
$response = OpenAI::chat()->create(
    model: 'gpt-4o-mini',
    messages: Messages::make()->system('You are a helpful assistant.')->user('Suggest me tasty fruits.'),
    responseFormat: ResponseFormat::make()->jsonSchema([
        'name' => 'response',
        'strict' => true,
        'schema' => [
            'type' => 'object',
            'properties' => [
                'fruits' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                ],
            ],
            'additionalProperties' => false,
            'required' => ['fruits'],
        ],
    ]),
)->json();
```

#### Streaming

```php
$response = OpenAI::chat()->stream(function (string $newChunk, string $message) {
    echo $newChunk;
})->create(
    model: 'gpt-3.5-turbo',
    messages: Messages::make()->system('You are a helpful assistant.')->user('Hello!'),
);
```

### Embeddings

```php
$response = OpenAI::embeddings()->create(
    'text-embedding-3-small',
    'The food was delicious and the waiter...'
);
// dd($response->embedding);
```

If you are storing the embedding vectors already somewhere else in your application then you might want to disable storing it within this package via passing a callback function with `storing(fn ($model) => $model)` method.

```php
$response = OpenAI::embeddings()->storing(function ($model) {
    $model->output = null;
    return $model;
})->create(
    'text-embedding-3-small',
    'The food was delicious and the waiter...'
);
```

### Files

Uploading file, retrieving it and deleting it afterwards.

```php
$file = OpenAI::files()->upload(
    file_get_contents('files/file.txt'),
    'file.txt',
    'assistants',
);
$files = OpenAI::files()->list();
$file2 = OpenAI::files()->retrieve($file->id);
$deletedFile = OpenAI::files()->delete($file->id);
// dd($file->response->json(), $file2->response->json(), $deletedFile->response->json());
```

Retrieving a file content.

```php
$fileContent = OpenAI::files()->retrieveContent($file->id);
```

### Vector Stores

```php
$filePath = __DIR__ . '/../test.txt';
$file = OpenAI::files()->upload(
    file_get_contents($filePath),
    basename($filePath),
    'assistants',
);

$vectorStore = OpenAI::vectorStores()->create([$file->id]);
$vectorStores = OpenAI::vectorStores()->list();
$vectorStoreRetrieved = OpenAI::vectorStores()->retrieve($vectorStore->id);
$vectorStoreModified = OpenAI::vectorStores()->modify($vectorStore->id, 'Modified vector store');
$vectorStoreDeleted = OpenAI::vectorStores()->delete($vectorStore->id);
```

### Threads

```php
$assistant = OpenAI::assistants()->create(
    'gpt-3.5-turbo',
    'Allan',
    'nova-openai testimiseks',
    'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.'
);
$thread = OpenAI::threads()
    ->create(Messages::make()->user('What is your purpose in one short sentence?'));
$message = OpenAI::threads()->messages()
    ->create($thread->id, ThreadMessage::user('How does AI work? Explain it in simple terms in one sentence.'));
$response = OpenAI::threads()->run()->execute($thread->id, $assistant->id)->wait()->json();

// cleanup
$deletedThread = OpenAI::threads()->delete($thread->id);
$deletedAssistant = OpenAI::assistants()->delete($assistant->id);
// dd(
//     $assistant->response->json(),
//     $thread->response->json(),
//     $message->response->json(),
//     $run->response->json(),
//     $messages->response->json(),
//     $deletedThread->response->json(),
//     $deletedAssistant->response->json(),
// );
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
