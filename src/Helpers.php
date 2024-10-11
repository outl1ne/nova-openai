<?php

namespace Outl1ne\NovaOpenAI;

class Helpers
{
    static public function json(string $response): ?object
    {
        $response = trim($response);
        $response = preg_replace('/^```json/', '', $response);
        $response = preg_replace('/```$/', '', $response);
        $response = trim($response);
        return json_decode($response);
    }
}
