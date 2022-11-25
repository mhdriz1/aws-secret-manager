<?php

namespace Mhdriz1\AwsSecretManager;

use Illuminate\Support\Facades\Config;
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
                __DIR__.'/../config/config.php' => config_path('secret-manager.php'),
            ], 'config');
        }

        $name = config('secret-manager.name');

        if($name) {
            $variables = AwsSecretManager::get($name);

            foreach($variables as $key => $secret) {
                Config::set($key, $secret);
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'secret-manager');

        // Register the main class to use with the facade
        $this->app->singleton('secret-manager', function () {
            return new AwsSecretManager;
        });
    }
}
