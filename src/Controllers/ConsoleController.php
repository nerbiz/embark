<?php

namespace Nerbiz\Embark\Controllers;

use Illuminate\Foundation\Console\ClosureCommand;
use Nerbiz\Embark\EmbarkServiceProvider;
use Nerbiz\Embark\ConsoleMessages\RestructureBaseMessages;
use Nerbiz\Embark\ConsoleMessages\RestructureModelsMessages;
use Nerbiz\Embark\ConsoleMessages\WebpackMessages;
use Nerbiz\Embark\Restructure\RestructureBase;
use Nerbiz\Embark\Restructure\RestructureModels;

class ConsoleController
{
    /**
     * @var ClosureCommand
     */
    protected $command;

    /**
     * @param ClosureCommand $command
     */
    public function __construct(ClosureCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Move Laravel and public files to separate directories
     * @return bool
     */
    public function restructureBase(): bool
    {
        $restructureBase = app()->make(RestructureBase::class);
        $restructureBaseMessages = app()->make(RestructureBaseMessages::class, [
            'command' => $this->command
        ]);

        // Check if the restructuring has been done already
        if ($restructureBase->isDoneAlready()) {
            $restructureBaseMessages->infoDoneAlready();
            $restructureBaseMessages->infoAborted();
            return false;
        }

        // Ask for confirmation before continuing
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

        return true;
    }

    /**
     * Move the User model to the Models namespace
     * @return bool
     */
    public function restructureModels(): bool
    {
        $restructureModels = app()->make(RestructureModels::class);
        $restructureModelsMessages = app()->make(RestructureModelsMessages::class, [
            'command' => $this->command
        ]);

        // Check if the restructuring has been done already
        if ($restructureModels->isDoneAlready()) {
            $restructureModelsMessages->infoDoneAlready();
            $restructureModelsMessages->infoAborted();
            return false;
        }

        // Ask for confirmation before continuing
        $restructureModelsMessages->infoConfirmation($restructureModels->getFileList());
        $confirmed = $restructureModelsMessages->askConfirmation();

        // Show 'aborting' text when the user didn't confirm
        if ($confirmed !== true) {
            $restructureModelsMessages->infoAborted();
            return false;
        }

        // Perform the restructuring
        $succeeded = $restructureModels->restructure();

        // Show the 'aborting' text, if something went wrong
        if ($succeeded === true) {
            $restructureModelsMessages->infoSucceeded();
            $restructureModelsMessages->commentModelCreation();
        } else {
            $restructureModelsMessages->infoAborted();
        }

        return true;
    }

    /**
     * Publish webpack.mix.js file, using custom public directory name
     * @return bool
     */
    public function publishWebpack(): bool
    {
        $webpackMessages = app()->make(WebpackMessages::class, [
            'command' => $this->command
        ]);

        $webpackMessages->warnDestructive();
        $webpackMessages->infoDescribe();
        $confirmed = $webpackMessages->askConfirmation();

        // Show 'aborting' text when the user didn't confirm
        if ($confirmed !== true) {
            $webpackMessages->infoAborted();
            return false;
        }

        // Get the stub content and adjust it
        $webpackStub = str_replace(
            'DummyPublicDirname',
            rtrim(config('embark.public_directory_name'), '/'),
            file_get_contents(EmbarkServiceProvider::getStubsPath('resources/webpack.mix.stub'))
        );

        // Update the file
        file_put_contents(base_path('webpack.mix.js'), $webpackStub);

        $webpackMessages->infoSucceeded();

        return true;
    }
}
