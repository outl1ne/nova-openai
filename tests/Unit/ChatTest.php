<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\ChatResponse;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\StreamedChatResponse;

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
            model: 'gpt-3.5-turbo',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Hello!'),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
    }

    public function test_chat_json_response(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-3.5-turbo',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Suggest me tasty fruits as JSON array of fruits.'),
            responseFormat: (new ResponseFormat)->json(),
        );
        $this->assertTrue($response instanceof ChatResponse);
        $this->assertIsArray($response->choices);
        $this->assertJson($response->choices[0]['message']['content']);
    }

    public function test_chat_stream(): void
    {
        $response = OpenAI::chat()->stream(function (string $newChunk, string $message) {
        })->create(
            model: 'gpt-3.5-turbo',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Hello!'),
        );
        $this->assertTrue($response instanceof StreamedChatResponse);
        $this->assertIsArray($response->choices);
    }
}
