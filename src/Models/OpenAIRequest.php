<?php

namespace Outl1ne\NovaOpenAI\Models;

use Illuminate\Database\Eloquent\Model;

class OpenAIRequest extends Model
{
    protected $table = 'openai_requests';

    protected $casts = [
        'input' => 'array',
        'output' => 'array',
        'meta' => 'array',
    ];
}
