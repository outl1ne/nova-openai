<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileResponse;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileListResponse;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileDeleteResponse;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileContentResponse;

class FilesTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function test_files(): void
    {
        $file = OpenAI::files()->upload(
            'sample file content',
            'file.txt',
            'assistants',
        );
        $this->assertTrue($file instanceof FileResponse);

        $files = OpenAI::files()->list();
        $this->assertTrue($files instanceof FileListResponse);

        $file2 = OpenAI::files()->retrieve($file->id);
        $this->assertTrue($file2 instanceof FileResponse);

        $deletedFile = OpenAI::files()->delete($file->id);
        $this->assertTrue($deletedFile instanceof FileDeleteResponse);
    }

    // public function test_file_content_retrieval(): void
    // {
    //     $file = OpenAI::files()->upload(
    //         'sample file content',
    //         'fine-tune.txt',
    //         'fine-tune',
    //     );
    //     $this->assertTrue($file instanceof FileResponse);

    //     $fileContent = OpenAI::files()->retrieveContent($file->id);
    //     $this->assertTrue($fileContent instanceof FileContentResponse);
    // }
}
