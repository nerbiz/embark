<?php

use Nerbiz\Embark\Restructure\RestructureBase;

Artisan::command('embark:restructure', function () {
    $restructureBase = app()->make(RestructureBase::class, [
        'closureCommand' => $this
    ]);

    // Check if the restructuring has been done already
    if ($restructureBase->isDoneAlready()) {
        $restructureBase->showDoneAlreadyText();
        $restructureBase->showAbortingText();
        // return;
    }

    // Show a text before continuing
    $restructureBase->showConfirmationText();
    $confirmed = $restructureBase->askForConfirmation();

    if (! $confirmed) {
        $restructureBase->showAbortingText();
        return;
    }
})->describe('Move Laravel and public files to separate directories');
