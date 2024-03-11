<?php

namespace Outl1ne\NovaOpenAI\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Outl1ne\NovaOpenAI\Database\Factories\OpenAIRequestFactory;

class OpenAIRequest extends Model
{
    use HasFactory;

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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OpenAIRequestFactory::new();
    }
}
