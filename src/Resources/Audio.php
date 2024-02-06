<?php

namespace Outl1ne\NovaOpenAI\Resources;

use Exception;
use OpenAI\Client;
use OpenAI\Contracts\Resources\AudioContract;
use Outl1ne\NovaOpenAI\Models\OpenaiRequest;
use OpenAI\Responses\Audio\SpeechStreamResponse;
use OpenAI\Responses\Audio\TranscriptionResponse;
use OpenAI\Responses\Audio\TranslationResponse;

class Audio implements AudioContract
{
    protected $openAI;

    public function __construct(Client $openAI)
    {
        $this->openAI = $openAI;
    }

    public function speech(...$parameters): string
    {
        $start = microtime(true);

        $openaiRequest = new OpenaiRequest;
        $openaiRequest->method = 'audio';
        $openaiRequest->status = 'pending';
        $openaiRequest->model_requested = $parameters[0]['model'] ?? null;
        $openaiRequest->input = $parameters[0]['input'] ?? null;
        $openaiRequest->voice = $parameters[0]['voice'] ?? null;
        $openaiRequest->save();

        try {
            $response = $this->openAI->audio()->speech(...$parameters);

            $time = microtime(true) - $start;
            $openaiRequest->time = $time;
            $openaiRequest->status = 'success';
            $openaiRequest->save();

            return $response;
        } catch (Exception $e) {
            $time = microtime(true) - $start;
            $openaiRequest->time = $time;
            $openaiRequest->status = 'error';
            $openaiRequest->error = $e->getMessage();
            $openaiRequest->save();

            throw $e;
        }
        return null;
    }

    public function speechStreamed(...$parameters): SpeechStreamResponse
    {
        $response = $this->openAI->audio()->speechStreamed(...$parameters);
        return $response;
    }

    public function transcribe(...$parameters): TranscriptionResponse
    {
        $response = $this->openAI->audio()->transcribe(...$parameters);
        return $response;
    }

    public function translate(...$parameters): TranslationResponse
    {
        $response = $this->openAI->audio()->translate(...$parameters);
        return $response;
    }
}
