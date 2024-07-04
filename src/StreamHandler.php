<?php

namespace Outl1ne\NovaOpenAI;

use Closure;
use Exception;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\StreamedChatChunk;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Responses\StreamedChatResponse;

class StreamHandler
{
    public function __construct(protected ResponseInterface $response, protected Closure $streamCallback, protected Closure $firstChunkCallback)
    {
    }

    public function handle()
    {
        $body = $this->response->getBody();
        $rawResult = '';
        $allChunks = collect();

        $firstLoop = true;

        while (!$body->eof()) {
            $rawChunk = $body->read(1024);
            $rawResult .= $rawChunk;

            $lines = explode("\n\n", $rawResult);
            $lastLine = array_pop($lines);

            $rawResult = $lastLine;

            $newChunks = collect($lines)->map(fn ($line) => $this->convertLineToArray($line))->filter()->map(fn ($line) => new StreamedChatChunk($line));
            $allChunks = $allChunks->merge($newChunks);

            if ($firstLoop) {
                ($this->firstChunkCallback)($newChunks->first());
            }

            ($this->streamCallback)(
                $newChunks->map(fn ($streamChunk) => $streamChunk->choices[0]['delta']['content'] ?? null)->filter()->join(''),
                $allChunks->map(fn ($streamChunk) => $streamChunk->choices[0]['delta']['content'] ?? null)->filter()->join(''),
            );

            $firstLoop = false;
        }

        return new StreamedChatResponse($this->response, ...$allChunks->toArray());
    }

    protected function convertLineToArray(string $line): ?array
    {
        $position = strpos($line, '{');

        if ($position === false) {
            if ($line === 'data: [DONE]') {
                return null;
            }

            throw new Exception("Invalid data line: {$line}");
        }

        $json = substr($line, $position);

        return json_decode($json, true);
    }
}
