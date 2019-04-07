<?php

namespace Nerbiz\Embark;

use Illuminate\Support\ServiceProvider;
use Nerbiz\Embark\Commands\ClearLogsCommand;
use Nerbiz\Embark\Commands\MakeEmptyClassCommand;
use Nerbiz\Embark\Commands\MigrateMakeCommand;
use Nerbiz\Embark\Commands\ModelMakeCommand;
use Nerbiz\Embark\Commands\PublishWebpackCommand;
use Nerbiz\Embark\Commands\RestructureBaseCommand;
use Nerbiz\Embark\Commands\RestructureModelsCommand;
use Nerbiz\Embark\Commands\RunScheduledTaskCommand;

class EmbarkServiceProvider extends ServiceProvider
{
    /**
     * The location of the stubs of this package
     * @var null
     */
    protected static $stubsPath;

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
            $resourcesDir . 'views/' => resource_path('views'),
        ], 'embark-views');

        // Copy stub files to the resources directory
        $this->publishes([
            static::$stubsPath => resource_path('stubs'),
        ], 'embark-stubs');

        // Register the console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearLogsCommand::class,
                MakeEmptyClassCommand::class,
                MigrateMakeCommand::class,
                ModelMakeCommand::class,
                PublishWebpackCommand::class,
                RestructureBaseCommand::class,
                RestructureModelsCommand::class,
                RunScheduledTaskCommand::class,
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
        // Set the stubs path
        static::$stubsPath = dirname(__FILE__, 2) . '/stubs/';

        // Merge default config with custom config
        $this->mergeConfigFrom(dirname(__FILE__, 2) . '/config/embark.php', 'embark');
    }

    /**
     * Get the path to a stub file, can use custom path from config
     * @param string $path Path to a stub, relative from the stubs directory
     * @return string
     */
    public static function getStubsPath(string $path = ''): string
    {
        $customStubsPath = rtrim(config('embark.stubs_path'), '/') . '/';
        $path = ltrim($path, '/');

        // Use the custom path if it's readable
        if ($customStubsPath !== null && is_readable($customStubsPath . $path)) {
            return $customStubsPath . $path;
        }

        // Or use the default path
        return static::$stubsPath . $path;
    }
}
