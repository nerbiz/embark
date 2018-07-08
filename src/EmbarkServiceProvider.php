<?php

namespace Nerbiz\Embark;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Nerbiz\Embark\Commands\MakeEmptyClassCommand;
use Nerbiz\Embark\Commands\MigrateMakeCommand;
use Nerbiz\Embark\Commands\ModelMakeCommand;

class EmbarkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $configDir = dirname(__FILE__, 2) . '/config/';
        $resourcesDir = dirname(__FILE__, 2) . '/resources/';

        // Copy the config file to the config directory
        $this->publishes([
            $configDir . 'embark.php' => config_path('embark.php'),
        ], 'embark-config');

        // Copy basic views to the resources directory
        $this->publishes([
            $resourcesDir . 'views/base.blade.php' => resource_path('views/base.blade.php'),
            $resourcesDir . 'views/partials/head.blade.php' => resource_path('views/partials/head.blade.php'),
            $resourcesDir . 'views/pages/home.blade.php' => resource_path('views/pages/home.blade.php'),
        ], 'embark-views');

        // Load console routes
        $this->loadRoutesFrom(dirname(__FILE__, 2) . '/routes/console.php');

        // Register the console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEmptyClassCommand::class,
                MigrateMakeCommand::class,
                ModelMakeCommand::class,
            ]);
        }

        // Apply the varchar length fix if needed
        if (config('embark.string_length_fix') === true) {
            Schema::defaultStringLength(191);
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
