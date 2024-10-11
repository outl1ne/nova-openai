<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileDeleteResponse;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreResponse;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreListResponse;
use Outl1ne\NovaOpenAI\Capabilities\VectorStores\Responses\VectorStoreDeleteResponse;

class VectorStoreTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function test_vector_stores(): void
    {
        $filePath = __DIR__ . '/../test.txt';

        $file = OpenAI::files()->upload(
            file_get_contents($filePath),
            basename($filePath),
            'assistants',
        );

        $vectorStore = OpenAI::vectorStores()->create([$file->id]);
        $this->assertTrue($vectorStore instanceof VectorStoreResponse);

        $vectorStores = OpenAI::vectorStores()->list();
        $this->assertTrue($vectorStores instanceof VectorStoreListResponse);

        $vectorStoreRetrieved = OpenAI::vectorStores()->retrieve($vectorStore->id);
        $this->assertTrue($vectorStoreRetrieved instanceof VectorStoreResponse);

        $vectorStoreModified = OpenAI::vectorStores()->modify($vectorStore->id, 'Modified vector store');
        $this->assertEquals($vectorStoreModified->meta['name'], 'Modified vector store');
        $this->assertTrue($vectorStoreModified instanceof VectorStoreResponse);

        $vectorStoreDeleted = OpenAI::vectorStores()->delete($vectorStore->id);
        $this->assertTrue($vectorStoreDeleted instanceof VectorStoreDeleteResponse);

        OpenAI::files()->delete($file->id);
    }
}
