<?php

namespace Outl1ne\NovaOpenAI\Enums;

use Outl1ne\NovaOpenAI\Traits\EnumOptions;

enum OpenAIRequestMethod: string
{
    use EnumOptions;

    case COMPLETIONS = 'completions';
    case CHAT = 'chat';
    case EMBEDDINGS = 'embeddings';
    case AUDIO = 'audio';
    case EDITS = 'edits';
    case FILES = 'files';
    case MODELS = 'models';
    case FINE_TUNING = 'fineTuning';
    case FINE_TUNES = 'fineTunes';
    case MODERATIONS = 'moderations';
    case IMAGES = 'images';
    case ASSISTANTS = 'assistants';
    case THREADS = 'threads';

    public function label(): string
    {
        return match ($this) {
            self::COMPLETIONS => 'Completions',
            self::CHAT => 'Chat',
            self::EMBEDDINGS => 'Embeddings',
            self::AUDIO => 'Audio',
            self::EDITS => 'Edits',
            self::FILES => 'Files',
            self::MODELS => 'Models',
            self::FINE_TUNING => 'Fine tuning',
            self::FINE_TUNES => 'Fine tunes',
            self::MODERATIONS => 'Moderations',
            self::IMAGES => 'Images',
            self::ASSISTANTS => 'Assistants',
            self::THREADS => 'Threads',
        };
    }
}
