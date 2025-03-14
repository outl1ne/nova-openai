<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Message;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessageResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessagesResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\DeleteResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadDeletionStatusResponse;

class ThreadsTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function test_threads(): void
    {
        $assistant = OpenAI::assistants()->create(
            'gpt-4o-mini',
            'Allan',
            'nova-openai testimiseks',
            'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand. Answer all questions from all messaged from the user in a single message.'
        );
        $this->assertTrue($assistant instanceof AssistantResponse);

        $thread = OpenAI::threads()
            ->create(Messages::make()->user('What is your purpose in one short sentence?'));
        $this->assertTrue($thread instanceof ThreadResponse);

        $message = OpenAI::threads()->messages()
            ->create($thread->id, Message::user('How does AI work? Explain it in simple terms in one sentence.'));
        $this->assertTrue($message instanceof MessageResponse);

        $message2 = OpenAI::threads()->messages()
            ->create($thread->id, Message::user([
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
            ]));
        $this->assertTrue($message2 instanceof MessageResponse);

        $messages = OpenAI::threads()->run()->execute($thread->id, $assistant->id)->wait();
        $this->assertTrue($messages instanceof MessagesResponse);

        // cleanup
        $deletedThread = OpenAI::threads()->delete($thread->id);
        $this->assertTrue($deletedThread instanceof ThreadDeletionStatusResponse);
        $deletedAssistant = OpenAI::assistants()->delete($assistant->id);
        $this->assertTrue($deletedAssistant instanceof DeleteResponse);
    }
}
