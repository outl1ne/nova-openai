<?php

namespace Outl1ne\NovaOpenAI\Enums;

enum OpenaiRequestMethod: string
{
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
        return match($this) {
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

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
