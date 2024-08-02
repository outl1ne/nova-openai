<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Message;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\DeleteResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessageResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessagesResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\RunResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadDeletionStatusResponse;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadResponse;

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
            'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.'
        );
        $this->assertTrue($assistant instanceof AssistantResponse);

        $thread = OpenAI::threads()
            ->create((new Messages)->user('What is your purpose in one short sentence?'));
        $this->assertTrue($thread instanceof ThreadResponse);

        $message = OpenAI::threads()->messages()
            ->create($thread->id, Message::user('How does AI work? Explain it in simple terms in one sentence.'));
        $this->assertTrue($message instanceof MessageResponse);

        $run = OpenAI::threads()->run()->execute($thread->id, $assistant->id);
        $this->assertTrue($run instanceof RunResponse);

        $status = null;
        while ($status !== 'completed') {
            $runStatus = OpenAI::threads()->run()->retrieve($thread->id, $run->id);
            $this->assertTrue($runStatus instanceof RunResponse);
            if ($runStatus->status === 'completed') {
                $status = 'completed';
            }
            sleep(1);
        }

        $messages = OpenAI::threads()->messages()->list($thread->id);
        $this->assertTrue($messages instanceof MessagesResponse);

        // cleanup
        $deletedThread = OpenAI::threads()->delete($thread->id);
        $this->assertTrue($deletedThread instanceof ThreadDeletionStatusResponse);
        $deletedAssistant = OpenAI::assistants()->delete($assistant->id);
        $this->assertTrue($deletedAssistant instanceof DeleteResponse);
    }
}
