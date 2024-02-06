<?php

declare(strict_types=1);

namespace Outl1ne\NovaOpenAI;

use OpenAI\Client;
use OpenAI\Contracts\ClientContract;
use Outl1ne\NovaOpenAI\Resources\Chat;
use Outl1ne\NovaOpenAI\Resources\Audio;
use OpenAI\Contracts\Resources\ChatContract;
use Outl1ne\NovaOpenAI\Resources\Embeddings;
use OpenAI\Contracts\Resources\AudioContract;
use OpenAI\Contracts\Resources\EditsContract;
use OpenAI\Contracts\Resources\FilesContract;
use OpenAI\Contracts\Resources\ImagesContract;
use OpenAI\Contracts\Resources\ModelsContract;
use OpenAI\Contracts\Resources\ThreadsContract;
use OpenAI\Contracts\Resources\FineTunesContract;
use OpenAI\Contracts\Resources\AssistantsContract;
use OpenAI\Contracts\Resources\EmbeddingsContract;
use OpenAI\Contracts\Resources\FineTuningContract;
use OpenAI\Contracts\Resources\CompletionsContract;
use OpenAI\Contracts\Resources\ModerationsContract;

class NovaOpenAIClient implements ClientContract
{
    protected $openAI;

    public function __construct(Client $openAI)
    {
        $this->openAI = $openAI;
    }

    public function completions(): CompletionsContract
    {
        return $this->openAI->completions();
    }

    public function chat(): ChatContract
    {
        return new Chat($this->openAI);
    }

    public function embeddings(): EmbeddingsContract
    {
        return new Embeddings($this->openAI);
    }

    public function audio(): AudioContract
    {
        return new Audio($this->openAI);
    }

    public function edits(): EditsContract
    {
        return $this->openAI->edits();
    }

    public function files(): FilesContract
    {
        return $this->openAI->files();
    }

    public function models(): ModelsContract
    {
        return $this->openAI->models();
    }

    public function fineTuning(): FineTuningContract
    {
        return $this->openAI->fineTuning();
    }

    public function fineTunes(): FineTunesContract
    {
        return $this->openAI->fineTunes();
    }

    public function moderations(): ModerationsContract
    {
        return $this->openAI->moderations();
    }

    public function images(): ImagesContract
    {
        return $this->openAI->images();
    }

    public function assistants(): AssistantsContract
    {
        return $this->openAI->assistants();
    }

    public function threads(): ThreadsContract
    {
        return $this->openAI->threads();
    }
}
