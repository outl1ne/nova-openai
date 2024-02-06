<?php

namespace Outl1ne\NovaOpenAI;

use OpenAI;
use OpenAI\Client;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use OpenAI\Contracts\ClientContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OpenAI\Laravel\Exceptions\ApiKeyIsMissing;

class NovaOpenAIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load all data
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish migrations and config
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'nova-openai-migrations');

        $this->publishes([
            __DIR__ . '/../config/nova-openai.php' => config_path('nova-openai.php'),
        ], 'config');

        // Register resources
        Nova::resources(array_filter([
            NovaOpenAIConfig::resource('openai_request'),
        ]));

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-openai', __DIR__.'/../dist/js/entry.js');
            Nova::style('nova-openai', __DIR__.'/../dist/css/entry.css');
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        /** @var CachesRoutes $app */
        $app = $this->app;
        if ($app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/nova-openai')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-openai.php', 'nova-openai');

        // Workaround for openai-php/laravel requiring the configuration file to be published
        $this->mergeConfigFrom(__DIR__ . '/../config/openai.php', 'openai');

        $this->app->singleton(NovaOpenAIClient::class, static function (): ClientContract {
            $apiKey = config('openai.api_key');
            $organization = config('openai.organization');

            if (! is_string($apiKey) || ($organization !== null && ! is_string($organization))) {
                throw ApiKeyIsMissing::create();
            }

            return new NovaOpenAIClient(OpenAI::factory()
                ->withApiKey($apiKey)
                ->withOrganization($organization)
                ->withHttpHeader('OpenAI-Beta', 'assistants=v1')
                ->withHttpClient(new \GuzzleHttp\Client(['timeout' => config('openai.request_timeout', 30)]))
                ->make());
        });
        $this->app->alias(NovaOpenAIClient::class, 'nova-openai');
    }
}
