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



Artisan::command('embark:webpack', function () {
    $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');

    $webpackStub = str_replace(
        'DummyPublicDirname',
        $newPublicDirname,
        file_get_contents(dirname(__FILE__, 2) . '/stubs/resources/webpack.mix.stub')
    );

    file_put_contents(base_path('webpack.mix.js'), $webpackStub);
})->describe('Publish webpack.mix.js file, using custom public directory name');
