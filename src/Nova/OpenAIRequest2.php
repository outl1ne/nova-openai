<?php

namespace Outl1ne\NovaOpenAI\Nova;

use Laravel\Nova\Resource;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\DateTime;
use Outl1ne\NovaOpenAI\NovaOpenAIConfig;
use Laravel\Nova\Http\Requests\NovaRequest;

class OpenAIRequest extends Resource
{
    public static $model = \Outl1ne\NovaOpenAI\Models\OpenAIRequest::class;
    public static $displayInNavigation = false;

    public function title()
    {
        return "{$this->method} [{$this->id}]";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'method',
        'status',
        'time',
        'model_requested',
        'model_used',
        'time',
        'input',
        'output',
        'response_format',
        'response_object',
        'error',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Requests';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Badge::make('Status')
                ->types([
                    NovaOpenAIConfig::enum('openai_request_status')::PENDING->value => 'bg-zinc-600 text-zinc-200',
                    NovaOpenAIConfig::enum('openai_request_status')::SUCCESS->value => 'bg-emerald-600 text-emerald-200',
                    NovaOpenAIConfig::enum('openai_request_status')::ERROR->value => 'bg-rose-600 text-rose-200',
                ])->sortable(),
            Badge::make('Method')
                ->types([
                    NovaOpenAIConfig::enum('openai_request_method')::COMPLETIONS->value => 'bg-slate-600 text-slate-200',
                    NovaOpenAIConfig::enum('openai_request_method')::CHAT->value => 'bg-sky-600 text-sky-200',
                    NovaOpenAIConfig::enum('openai_request_method')::EMBEDDINGS->value => 'bg-amber-600 text-amber-200',
                    NovaOpenAIConfig::enum('openai_request_method')::AUDIO->value => 'bg-fuchsia-600 text-fuchsia-200',
                ])->sortable(),
            Text::make('Request time', 'time')->sortable()->displayUsing(fn () => "{$this->time} ms"),
            Text::make('Model requested', 'model_requested')->sortable(),
            Text::make('Model used', 'model_used')->sortable(),
            Text::make('Tokens', 'usage_total_tokens')->sortable(),
            Text::make('Input', 'input')->displayUsing(fn () => $this->jsonToText($this->input))->onlyOnIndex(),
            Text::make('Output', 'output')->displayUsing(fn () => $this->jsonToText($this->output))->onlyOnIndex(),
            Code::make('Input', 'input')->json(),
            Code::make('Output', 'output')->json(),
            Text::make('Error', 'error')->hideFromIndex(),
            Text::make('Object', 'response_object'),
            DateTime::make('Created at'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    protected function jsonToText($data): ?string
    {
        return $this->truncate(is_array($data) ? json_encode($data) : $data);
    }

    protected function truncate(?string $string): ?string
    {
        if ($string === null) return null;
        return Str::limit($string, 50);
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }
}