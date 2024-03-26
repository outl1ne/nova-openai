<?php

namespace Outl1ne\NovaOpenAI;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Outl1ne\NovaOpenAI\Exceptions\ApiKeyMissingException;
use Outl1ne\NovaOpenAI\Exceptions\OrganizationInvalidException;

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
        ], 'nova-openai-config');

        // Register resources
        Nova::resources(array_filter([
            NovaOpenAIConfig::resource('openai_request'),
        ]));

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-openai', __DIR__ . '/../dist/js/entry.js');
            Nova::style('nova-openai', __DIR__ . '/../dist/css/entry.css');
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
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-openai.php', 'nova-openai');

        $this->app->singleton(OpenAI::class, static function (): OpenAI {
            $apiKey = config('nova-openai.api_key');
            $organization = config('nova-openai.organization');
            $headers = config('nova-openai.headers');
            $pricingPath = config('nova-openai.pricing') ?? __DIR__ . '/../resources/openai-pricing.json';
            $pricing = json_decode(file_get_contents($pricingPath));

            if (!is_string($apiKey)) {
                throw new ApiKeyMissingException;
            }

            if ($organization !== null && !is_string($organization)) {
                throw new OrganizationInvalidException;
            }

            return (new Factory())
                ->withApiKey($apiKey)
                ->withOrganization($organization)
                ->withHttpHeaders($headers)
                ->withPricing($pricing)
                ->make();
        });
        $this->app->alias(OpenAI::class, 'nova-openai');
    }
}
