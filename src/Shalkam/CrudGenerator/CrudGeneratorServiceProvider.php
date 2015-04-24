<?php

namespace Shalkam\CrudGenerator;

use Illuminate\Support\ServiceProvider;
use Shalkam\CrudGenerator\CreateCommand;

class CrudGeneratorServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('make:crud', function ($app) {
            return new CreateCommand();
        });
        $this->commands(['make:crud']);
    }

    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/views', 'crud');
        $this->publishes([
            __DIR__ . '/adminlte/' => public_path('adminlte/'),
                ], 'assets');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

}
