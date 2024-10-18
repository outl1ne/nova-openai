<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\ChatResponse;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\StreamedChatResponse;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonArray;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonObject;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonSchema;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonString;

class ChatTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function test_chat(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-4o-mini',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Hello!'),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
    }

    public function test_chat_json_response(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-4o-mini',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Suggest me tasty fruits as JSON array of fruits.'),
            responseFormat: (new ResponseFormat)->json(),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
        $this->assertJson($response->choices[0]['message']['content']);
    }

    public function test_chat_json_schema_response(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-4o-mini',
            messages: Messages::make()->system('You are a helpful assistant.')->user('Suggest me tasty fruits.'),
            responseFormat: ResponseFormat::make()->jsonSchema(JsonObject::make()->property('fruits', JsonArray::make()->items(JsonString::make()))),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->json()?->fruits);

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
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->json()?->fruits);
    }

    public function test_chat_stream(): void
    {
        $response = OpenAI::chat()->stream(function (string $newChunk, string $message) {})->create(
            model: 'gpt-4o-mini',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Hello!'),
        );
        $this->assertTrue($response instanceof StreamedChatResponse);
        $this->assertIsArray($response->choices);
    }

    public function test_chat_image_url(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-4o-mini',
            messages: (new Messages)->system('You are a helpful assistant.')->user([
                [
                    'type' => 'text',
                    'text' => 'Describe what\'s on the attached photo',
                ],
                [
                    'type' => 'image_url',
                    'image_url' => [
                        'url' => 'https://img-cdn.pixlr.com/image-generator/history/65bb506dcb310754719cf81f/ede935de-1138-4f66-8ed7-44bd16efc709/medium.webp',
                    ],
                ],
            ]),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
    }
}
