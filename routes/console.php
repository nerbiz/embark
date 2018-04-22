<?php

use Nerbiz\Embark\Restructure\RestructureBase;

Artisan::command('embark:restructure', function () {
    $restructureBase = app()->make(RestructureBase::class, [
        'command' => $this
    ]);

    // Check if the restructuring has been done already
    if ($restructureBase->isDoneAlready()) {
        $restructureBase->showDoneAlreadyText();
        $restructureBase->showFailedText();
        return;
    }

    // Show a text before continuing
    $restructureBase->showConfirmationText();
    $confirmed = $restructureBase->askForConfirmation();

    // Show 'aborting' text when the user didn't confirm
    if ($confirmed !== true) {
        $restructureBase->showFailedText();
        return;
    }

    // Perform the restructuring
    $succeeded = $restructureBase->restructure();

    // Show the 'aborting' text, if something went wrong
    if ($succeeded === true) {
        $restructureBase->showSucceededText();
    } else {
        $restructureBase->showFailedText();
    }
})->describe('Move Laravel and public files to separate directories');
