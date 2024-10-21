<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonAnyOf;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\ChatResponse;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonEnum;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\StreamedChatResponse;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonArray;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonNumber;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonObject;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonString;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonBoolean;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\JsonSchema\JsonInteger;

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
            messages: Messages::make()->system('You are a helpful assistant.')->user('Hello!'),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
    }

    public function test_chat_json_response(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-4o-mini',
            messages: Messages::make()->system('You are a helpful assistant.')->user('Suggest me tasty fruits as JSON array of fruits.'),
            responseFormat: ResponseFormat::make()->json(),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
        $this->assertJson($response->choices[0]['message']['content']);
    }

    public function test_chat_json_schema_response(): void
    {
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
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->json()?->fruits);
        $this->assertIsInt($response->json()?->number_of_fruits_in_response);
        $this->assertIsFloat($response->json()?->number_of_fruits_in_response_divided_by_three);
        $this->assertIsBool($response->json()?->is_number_of_fruits_in_response_even);
        $this->assertIsString($response->json()?->fruit_most_occurring_color);

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
            messages: Messages::make()->system('You are a helpful assistant.')->user('Hello!'),
        );
        $this->assertTrue($response instanceof StreamedChatResponse);
        $this->assertIsArray($response->choices);
    }

    public function test_chat_image_url(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-4o-mini',
            messages: Messages::make()->system('You are a helpful assistant.')->user([
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
