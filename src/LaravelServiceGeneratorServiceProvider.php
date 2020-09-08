<?php

namespace Yarob\LaravelServiceGenerator;

use Illuminate\Support\ServiceProvider;
use Yarob\LaravelServiceGenerator\Console\ServiceMakeCommand;
use Yarob\LaravelServiceGenerator\Console\ServiceInterfaceMakeCommand;

class LaravelServiceGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(__DIR__.'/../config/laravelService.php', 'laravelServiceGenerator');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Console/stubs' => base_path('stubs')
        ], 'stubs');

        $this->publishes([
            __DIR__.'/../config/laravelService.php' => config_path('laravelService.php')
        ], 'config');
        
        $this->commands([
            ServiceMakeCommand::class,
            ServiceInterfaceMakeCommand::class
        ]);
    }
}
