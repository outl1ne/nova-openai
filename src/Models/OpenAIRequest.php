<?php

namespace Outl1ne\NovaOpenAI\Models;

use Illuminate\Database\Eloquent\Model;

class OpenAIRequest extends Model
{
    protected $table = 'openai_requests';

    protected $casts = [
        'input' => 'array',
        'output' => 'array',
        'arguments' => 'array',
        'meta' => 'array',
    ];

    public function appendArgument(string $key, $value)
    {
        if ($value === null) {
            return false;
        }

        $this->arguments = [
            ...$this->arguments,
            $key => $value,
        ];

        return true;
    }
}
