<?php

namespace Nerbiz\Embark;

use Illuminate\Support\ServiceProvider;
use Nerbiz\Embark\Commands\MakeEmptyClassCommand;
use Nerbiz\Embark\Commands\MigrateMakeCommand;

class EmbarkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Copy the config file to the config directory
        $this->publishes([
            dirname(__FILE__, 2) . '/config/embark.php' => config_path('embark.php')
        ], 'embark-config');

        // Copy .scss files to the resources directory
        $this->publishes([
            dirname(__FILE__, 2) . '/scss' => resource_path('assets/sass/embark')
        ], 'embark-scss');

        // Load console routes
        $this->loadRoutesFrom(dirname(__FILE__, 2) . '/routes/console.php');

        // Register the console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEmptyClassCommand::class,
                MigrateMakeCommand::class
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge default config with custom config
        $this->mergeConfigFrom(dirname(__FILE__, 2) . '/config/embark.php', 'embark');
    }
}
