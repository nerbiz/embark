<?php

use Nerbiz\Embark\Controllers\ConsoleController;


Artisan::command('embark:restructure', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->restructureBase();
})->describe('Move Laravel and public files to separate directories');


Artisan::command('embark:models-namespace', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->restructureModels();
})->describe(sprintf('Create the App\%s namespace and move User to it', config('embark.models_namespace')));


Artisan::command('embark:webpack', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->publishWebpack();
})->describe('Publish webpack.mix.js file, using custom public directory name');


Artisan::command('embark:clear-logs', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->clearLogs();
})->describe('Remove all *.log files from storage/logs');
