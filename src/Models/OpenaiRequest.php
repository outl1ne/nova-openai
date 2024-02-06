<?php

namespace Outl1ne\NovaOpenAI\Models;

use Illuminate\Database\Eloquent\Model;

class OpenaiRequest extends Model
{
    protected $casts = [
        'input' => 'array',
        'output' => 'array',
    ];
}
