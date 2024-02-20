<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;

class OpenAIRequestSeeder extends Seeder
{
    public function run(): void
    {
        // for ($i = 0; $i < 3; $i++) {
        // }
        // OpenAI::chat()->create(
        //     model: 'gpt-3.5-turbo',
        //     messages: (new Messages)->system('You are a helpful assistant.')->user('Hello!'),
        // );
        // OpenAI::embeddings()->create('text-embedding-3-small', 'The food was delicious and the waiter...', null, dimensions: 256);
        // OpenAI::audio()->speech([
        //     'model' => 'tts-1',
        //     'input' => 'The quick brown fox jumped over the lazy dog.',
        //     'voice' => 'alloy',
        // ]);
    }
}
