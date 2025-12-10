<?php

namespace KawsarAhmad43\Logeon\Providers;

use Illuminate\Support\ServiceProvider;

class LogeonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/logeon.php', 'logeon'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'logeon');

        // Publish config
        $this->publishes([
            __DIR__.'/../../config/logeon.php' => config_path('logeon.php'),
        ], 'logeon-config');

        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/logeon'),
        ], 'logeon-views');

        // Publish assets (CSS, JS)
        $this->publishes([
            __DIR__.'/../../resources/assets' => public_path('vendor/logeon'),
        ], 'logeon-assets');

        // Publish all
        $this->publishes([
            __DIR__.'/../../config/logeon.php' => config_path('logeon.php'),
            __DIR__.'/../../resources/views' => resource_path('views/vendor/logeon'),
            __DIR__.'/../../resources/assets' => public_path('vendor/logeon'),
        ], 'logeon');
    }
}
