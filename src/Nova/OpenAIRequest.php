<?php

namespace Outl1ne\NovaOpenAI\Nova;

use Laravel\Nova\Resource;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaOpenAI\Enums\OpenAIRequestMethod;
use Outl1ne\NovaOpenAI\Enums\OpenAIRequestStatus;

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
        'input',
        'output',
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
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'openai-requests';
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
                    OpenAIRequestStatus::PENDING->value => 'bg-zinc-600 text-zinc-200',
                    OpenAIRequestStatus::SUCCESS->value => 'bg-emerald-600 text-emerald-200',
                    OpenAIRequestStatus::ERROR->value => 'bg-rose-600 text-rose-200',
                ])->sortable(),
            Badge::make('Method')
                ->types([
                    OpenAIRequestMethod::COMPLETIONS->value => 'bg-slate-600 text-slate-200',
                    OpenAIRequestMethod::CHAT->value => 'bg-sky-600 text-sky-200',
                    OpenAIRequestMethod::EMBEDDINGS->value => 'bg-amber-600 text-amber-200',
                    OpenAIRequestMethod::AUDIO->value => 'bg-fuchsia-600 text-fuchsia-200',
                    OpenAIRequestMethod::THREADS->value => 'bg-neutral-600 text-neutral-200',
                    OpenAIRequestMethod::ASSISTANTS->value => 'bg-teal-600 text-teal-200',
                    OpenAIRequestMethod::FILES->value => 'bg-gray-600 text-gray-200',
                ])->sortable(),
            Number::make('Cost', 'cost')->sortable()->displayUsing(fn ($value) => $value === null ? null : '$' . number_format($value, 4)),
            Text::make('Request time', 'time_sec')->sortable()->displayUsing(fn () => "{$this->time_sec} sec"),
            Text::make('Model requested', 'model_requested')->sortable(),
            Text::make('Model used', 'model_used')->sortable(),
            Text::make('Tokens', 'usage_total_tokens')->sortable(),
            Text::make('Input', 'input')->displayUsing(fn () => $this->jsonToText($this->input))->onlyOnIndex(),
            Text::make('Output', 'output')->displayUsing(fn () => $this->jsonToText($this->output))->onlyOnIndex(),
            Code::make('Input', 'input')->json(),
            Code::make('Output', 'output')->json(),
            Code::make('Arguments', 'arguments')->json(),
            Code::make('Meta', 'meta')->json(),
            Text::make('Error', 'error')->hideFromIndex(),
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
        return [
            new CostMetrics,
        ];
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

    protected function jsonToText($data): string
    {
        return Str::of(is_array($data) ? json_encode($data) : $data)->limit(50);
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
