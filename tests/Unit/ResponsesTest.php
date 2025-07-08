<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;

class ResponsesTest extends \Orchestra\Testbench\TestCase
{
    public function test_responses_create(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o-mini',
            input: 'Hello, world!'
        );

        $this->assertNotNull($response);
        $this->assertIsArray($response->output);
        $this->assertIsString($response->id);
        $this->assertIsString($response->status);
    }

    public function test_responses_create_with_instructions(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o-mini',
            input: 'Tell me about cats',
            instructions: 'You are a helpful assistant that provides detailed information about animals.'
        );

        $this->assertNotNull($response);
        $this->assertIsArray($response->output);
        $this->assertIsString($response->id);
        $this->assertIsString($response->status);
    }

    public function test_responses_create_with_previous_response(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o-mini',
            input: 'Hello, world!'
        );

        $secondResponse = OpenAI::responses()->create(
            model: 'gpt-4o-mini',
            input: 'Tell me more',
            previousResponseId: $response->id
        );

        $this->assertNotNull($secondResponse);
        $this->assertIsArray($secondResponse->output);
        $this->assertIsString($secondResponse->id);
        $this->assertNotEquals($response->id, $secondResponse->id);
    }

    public function test_responses_retrieve(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o-mini',
            input: 'Hello, world!'
        );

        $retrievedResponse = OpenAI::responses()->retrieve($response->id);

        $this->assertNotNull($retrievedResponse);
        $this->assertEquals($response->id, $retrievedResponse->id);
        $this->assertIsArray($retrievedResponse->output);
    }

    public function test_responses_with_tools(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o',
            input: 'What is the weather like today?',
            tools: [
                [
                    'type' => 'function',
                    'function' => [
                        'name' => 'get_weather',
                        'description' => 'Get the current weather',
                        'parameters' => [
                            'type' => 'object',
                            'properties' => [
                                'location' => ['type' => 'string']
                            ],
                            'required' => ['location']
                        ]
                    ]
                ]
            ]
        );

        $this->assertNotNull($response);
        $this->assertIsArray($response->output);
    }

    public function test_responses_with_reasoning(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o',
            input: 'Solve this math problem: 2 + 2 = ?',
            reasoning: ['effort' => 'medium']
        );

        $this->assertNotNull($response);
        $this->assertIsArray($response->output);
        $this->assertIsString($response->id);
    }

    public function test_responses_with_text_format(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o-mini',
            input: 'Write a haiku about programming',
            text: [
                'format' => [
                    'type' => 'text'
                ]
            ]
        );

        $this->assertNotNull($response);
        $this->assertIsArray($response->output);
        $this->assertIsString($response->id);
    }

    public function test_responses_background_mode(): void
    {
        $response = OpenAI::responses()->create(
            model: 'gpt-4o',
            input: 'Write a detailed analysis of artificial intelligence',
            background: true,
            store: true
        );

        $this->assertNotNull($response);
        $this->assertIsString($response->id);
        $this->assertContains($response->status, ['queued', 'in_progress', 'completed']);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Outl1ne\NovaOpenAI\NovaOpenAIServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'OpenAI' => \Outl1ne\NovaOpenAI\Facades\OpenAI::class,
        ];
    }
} 