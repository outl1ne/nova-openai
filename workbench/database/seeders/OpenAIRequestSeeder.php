<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Outl1ne\NovaOpenAI\Facades\OpenAI;

class OpenAIRequestSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            // OpenAI::chat()->create([
            //     'model' => 'gpt-3.5-turbo',
            //     'messages' => [
            //         [
            //             'role' => 'user',
            //             'content' => 'Hello!'
            //         ],
            //     ],
            // ]);
            // OpenAI::embeddings()->create('text-embedding-3-small', 'The food was delicious and the waiter...');
        }
        // OpenAI::audio()->speech([
        //     'model' => 'tts-1',
        //     'input' => 'The quick brown fox jumped over the lazy dog.',
        //     'voice' => 'alloy',
        // ]);
    }
}
