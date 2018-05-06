<?php

use Nerbiz\Embark\Controllers\ConsoleController;


Artisan::command('embark:restructure', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->restructureBase();
})->describe('Move Laravel and public files to separate directories');


Artisan::command('embark:models-namespace', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->restructureModels();
})->describe('Create the App\Models namespace and move User to it');


Artisan::command('embark:webpack', function () {
    $consoleController = app()->make(ConsoleController::class, ['command' => $this]);
    $consoleController->publishWebpack();
})->describe('Publish webpack.mix.js file, using custom public directory name');
