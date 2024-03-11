<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages as ThreadMessages;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Message as ThreadMessage;

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
        // $thread = OpenAI::threads()->create();
        // $messages = OpenAI::threads()->messages()->list($thread->response()->json()['id']);
        // $messageFiles = OpenAI::threads()->messages()->listFiles($thread->response()->json()['id'], $message->response()->json()['id']);
        // $message2 = OpenAI::threads()->messages()->retrieve($thread->response()->json()['id'], $message->response()->json()['id']);
        // $message3 = OpenAI::threads()->messages()->modify($thread->response()->json()['id'], $message->response()->json()['id'], [
        //     'foo' => 'bar',
        // ]);
        // $message2file = OpenAI::threads()->messages()->retrieveFile($thread->response()->json()['id'], $message->response()->json()['id']);
        // $thread2 = OpenAI::threads()->retrieve($thread->response()->json()['id']);
        // $thread3 = OpenAI::threads()->modify($thread->response()->json()['id'], [
        //     'modified' => true,
        //     'user' => 'abc123',
        // ]);
        // $thread4 = OpenAI::threads()->delete($thread->response()->json()['id']);
        // dd($thread->response()->json(), $message->response()->json(), $messages->response()->json(), $messageFiles->response()->json(), $message2->response()->json(), $message3->response()->json());
        // dd($thread->response()->json(), $message->response()->json(), $run->response()->json());

        // $assistant = OpenAI::assistants()->create('gpt-3.5-turbo', 'Allan', 'nova-openai testimiseks', 'You are a kindergarten teacher. When asked a questions, anwser shortly and as a young child could understand.');
        // $thread = OpenAI::threads()->create((new ThreadMessages)->user('What is your purpose in one short sentence?'));
        // $message = OpenAI::threads()->messages()->create($thread->response()->json()['id'], ThreadMessage::user('How does AI work? Explain it in simple terms in one sentence.'));
        // $run = OpenAI::threads()->run()->execute($thread->response()->json()['id'], $assistant->response()->json()['id']);
        // $status = null;
        // while ($status !== 'completed') {
        //     $runStatus = OpenAI::threads()->run()->retrieve($thread->response()->json()['id'], $run->response()->json()['id']);
        //     if ($runStatus->response()->json()['status'] === 'completed') {
        //         echo '# run completed' . PHP_EOL;
        //         $status = 'completed';
        //     } else {
        //         echo '# run not completed yet, trying again' . PHP_EOL;
        //     }
        //     sleep(1);
        // }
        // $messages = OpenAI::threads()->messages()->list($thread->response()->json()['id']);
        // dd($thread->response()->json(), $message->response()->json(), $run->response()->json(), $messages->response()->json());
    }
}
