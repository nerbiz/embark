<?php

use Nerbiz\Embark\Restructure\RestructureBase;
use Nerbiz\Embark\ConsoleMessages\RestructureBaseMessages;
use Nerbiz\Embark\ConsoleMessages\WebpackMessages;

Artisan::command('embark:restructure', function () {
    $restructureBase = app()->make(RestructureBase::class, [
        'command' => $this
    ]);

    $restructureBaseMessages = app()->make(RestructureBaseMessages::class, [
        'command' => $this
    ]);

    // Check if the restructuring has been done already
    if ($restructureBase->isDoneAlready()) {
        $restructureBaseMessages->infoDoneAlready();
        $restructureBaseMessages->infoAborted();
        return false;
    }

    // Show a text before continuing
    $restructureBaseMessages->infoConfirmation($restructureBase->getExcludedList());
    $confirmed = $restructureBaseMessages->askConfirmation();

    // Show 'aborting' text when the user didn't confirm
    if ($confirmed !== true) {
        $restructureBaseMessages->infoAborted();
        return false;
    }

    // Perform the restructuring
    $succeeded = $restructureBase->restructure();

    // Show the 'aborting' text, if something went wrong
    if ($succeeded === true) {
        $restructureBaseMessages->infoSucceeded();
        $restructureBaseMessages->commentChangeDir();
    } else {
        $restructureBaseMessages->infoAborted();
    }
})->describe('Move Laravel and public files to separate directories');



Artisan::command('embark:webpack', function () {
    $webpackMessages = app()->make(WebpackMessages::class, [
        'command' => $this
    ]);

    $webpackMessages->warnDestructive();
    $webpackMessages->infoDescribe();
    $confirmed = $webpackMessages->askConfirmation();

    // Show 'aborting' text when the user didn't confirm
    if ($confirmed !== true) {
        $webpackMessages->infoAborted();
        return false;
    }

    $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');

    $webpackStub = str_replace(
        'DummyPublicDirname',
        $newPublicDirname,
        file_get_contents(dirname(__FILE__, 2) . '/stubs/resources/webpack.mix.stub')
    );

    file_put_contents(base_path('webpack.mix.js'), $webpackStub);

    $webpackMessages->infoSucceeded();
})->describe('Publish webpack.mix.js file, using custom public directory name');
