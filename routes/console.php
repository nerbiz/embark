<?php

use Nerbiz\Embark\Commands\RestructureCommand;

Artisan::command('embark:restructure', function () {
    $restructureCommand = app()->make(RestructureCommand::class, [
        'command' => $this
    ]);

    if ($restructureCommand->doneAlready()) {
        $restructureCommand->notifyDoneAlready();
        $restructureCommand->showAbortingText();
        return;
    }

    // Show a text before continuing
    $restructureCommand->showConfirmationText();
    $confirmed = $restructureCommand->askForConfirmation();

    if (! $confirmed) {
        $restructureCommand->showAbortingText();
        return;
    }
})->describe('Move Laravel and public files to separate directories');
