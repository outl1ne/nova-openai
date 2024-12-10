<?php

namespace Workbench\App\Console\Commands;

use Illuminate\Console\Command;
use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;

class TestAiChatCreate extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */

   protected $signature = 'test-ai-chat-create';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Test OpenAI Chat Creation';

   /**
    * Execute the console command.
    */
   public function handle()
   {
      $messages = new Messages();
      $messages->user("Respond with only 'Yes'");

      $responseFormat = new ResponseFormat();
      $responseFormat->text();

      $chat = OpenAI::chat()->create(
         model: "gpt-4o-mini",
         messages: $messages,
         requestName: 'name123',
         responseFormat: $responseFormat,
         maxTokens: 4096,
         temperature: 0,
      );
   }
}
