<?php

namespace Mhdriz1\AwsSecretManager;

use Illuminate\Support\ServiceProvider;

class AwsSecretManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('aws-secret-manager.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'aws-secret-manager');

        // Register the main class to use with the facade
        $this->app->singleton('aws-secret-manager', function () {
            return new AwsSecretManager;
        });
    }
}
