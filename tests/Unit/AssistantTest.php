<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileResponse;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileDeleteResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\DeleteResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantFileResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantListResponse;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantFileListResponse;

class AssistantTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function test_assistant(): void
    {
        $assistant = OpenAI::assistants()->create(
            'gpt-4o-mini',
            'Allan\'s assistant',
            'For testing purposes of nova-openai package.',
            'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.',
        );
        $this->assertTrue($assistant instanceof AssistantResponse);

        $assistantModified = OpenAI::assistants()->modify($assistant->id, null, 'Allan\'s assistant!');
        $this->assertTrue($assistantModified instanceof AssistantResponse);

        $assistants = OpenAI::assistants()->list();
        $this->assertTrue($assistants instanceof AssistantListResponse);

        $deletedAssistant = OpenAI::assistants()->delete($assistant->id);
        $this->assertTrue($deletedAssistant instanceof DeleteResponse);
    }

    public function test_assistant_files(): void
    {
        $assistant = OpenAI::assistants()->create(
            'gpt-4o-mini',
            'Allan\'s assistant',
            'For testing purposes of nova-openai package.',
            'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.',
            [
                [
                    'type' => 'file_search',
                ],
            ],
        );
        $this->assertTrue($assistant instanceof AssistantResponse);

        $file = OpenAI::files()->upload(
            'sample file content',
            'test_assistant_files.txt',
            'assistants',
        );
        $this->assertTrue($file instanceof FileResponse);

        $assistantFile = OpenAI::assistants()->files()->create($assistant->id, $file->id);
        $this->assertTrue($assistantFile instanceof AssistantFileResponse);

        $assistantFiles = OpenAI::assistants()->files()->list($assistant->id);
        $this->assertTrue($assistantFiles instanceof AssistantFileListResponse);

        $deletedAssistantFile = OpenAI::assistants()->files()->delete($assistant->id, $file->id);
        $this->assertTrue($deletedAssistantFile instanceof DeleteResponse);

        // Cleanup
        $deletedAssistant = OpenAI::assistants()->delete($assistant->id);
        $this->assertTrue($deletedAssistant instanceof DeleteResponse);

        $deletedFile = OpenAI::files()->delete($file->id);
        $this->assertTrue($deletedFile instanceof FileDeleteResponse);
    }
}
