<?php

namespace Tests\Unit;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\EmbeddingsResponse;

class EmbeddingsTest extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function test_embeddings(): void
    {
        $response = OpenAI::embeddings()->create(
            'text-embedding-3-small',
            'The food was delicious and the waiter...'
        );
        $this->assertTrue($response instanceof EmbeddingsResponse);
        $this->assertIsArray($response->embedding->vector);
    }

    public function test_embeddings_without_storing_output(): void
    {
        $response = OpenAI::embeddings()->storing(function ($model) {
            $model->output = null;
            return $model;
        })->create(
            'text-embedding-3-small',
            'The food was delicious and the waiter...'
        );
        $this->assertTrue($response->request->output === null);
    }
}
