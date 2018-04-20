<?php

use Nerbiz\Embark\Commands\RestructureCommand;

Artisan::command('embark:restructure', function () {
    $restructureCommand = app()->make(RestructureCommand::class, [
        'command' => $this
    ]);

    // Show a text before continuing
    $restructureCommand->showConfirmationText();
})->describe('Move Laravel and public files to separate directories');
