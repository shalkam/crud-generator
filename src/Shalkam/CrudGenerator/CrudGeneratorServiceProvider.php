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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

}