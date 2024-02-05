<?php

namespace Outl1ne\NovaOpenAI;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Outl1ne\NovaTranslationsLoader\LoadsNovaTranslations;

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
    }
}
