<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages as ThreadMessages;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Message as ThreadMessage;

class OpenAIRequestSeeder extends Seeder
{
    public function run(): void
    {
        $response = OpenAI::chat()->create(
            model: 'gpt-3.5-turbo',
            messages: (new Messages)->system('You are a helpful assistant.')->user('Write me a poem with 8 rows.'),
        );
        dd('asd');
        // $response = OpenAI::chat()->stream(function ($chunk, $result) {
        //     echo $chunk;
        // })->create(
        //     model: 'gpt-3.5-turbo',
        //     messages: (new Messages)->system('You are a helpful assistant.')->user('Write me a poem with 8 rows.'),
        // );

        // $body = $response->getBody();
        // $i = 0;
        // while (!$body->eof()) {
        //     $chunk = $body->read(1024);
        //     // dd($chunk);
        //     echo "[{$i}] ";
        //     echo $chunk;
        //     $i++;
        // }
        // dd($response->response()->json());
    }
}
