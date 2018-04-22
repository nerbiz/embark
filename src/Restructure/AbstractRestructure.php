<?php

namespace Nerbiz\Embark\Restructure;

use Illuminate\Foundation\Console\ClosureCommand;

abstract class AbstractRestructure
{
    /**
     * @var ClosureCommand
     */
    protected $command;

    /**
     * Whether or not the user confirmed to continue
     * @var boolean
     */
    protected $confirmed;

    /**
     * @param ClosureCommand $command
     */
    public function __construct(ClosureCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Check if the restructuring is done already
     * @return boolean
     */
    abstract public function isDoneAlready();

    /**
     * Notify that the restructuring has been done already
     * @return void
     */
    public function showDoneAlreadyText()
    {
        $this->command->info('Restructuring seems to have been done already');
    }

    /**
     * Perform the restructuring operations
     * @return boolean Indicates if the restructuring succeeded or not
     */
    abstract public function restructure();

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function showSucceededText()
    {
        $this->command->info('Restructuring is finished');
    }

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function showFailedText()
    {
        $this->command->info('Restructuring is aborted');
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }
}
