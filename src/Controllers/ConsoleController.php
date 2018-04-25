<?php

namespace Nerbiz\Embark\Controllers;

use Illuminate\Foundation\Console\ClosureCommand;
use Nerbiz\Embark\ConsoleMessages\RestructureBaseMessages;
use Nerbiz\Embark\ConsoleMessages\WebpackMessages;
use Nerbiz\Embark\Restructure\RestructureBase;

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
     * @return boolean
     */
    public function base()
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

        return true;
    }

    /**
     * Publish webpack.mix.js file, using custom public directory name
     * @return boolean
     */
    public function webpack()
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
            file_get_contents(dirname(__FILE__, 2) . '/stubs/resources/webpack.mix.stub')
        );

        // Update the file
        file_put_contents(base_path('webpack.mix.js'), $webpackStub);

        $webpackMessages->infoSucceeded();

        return true;
    }
}
