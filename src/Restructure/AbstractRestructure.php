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
     * Perform the restructuring operations
     * @return void
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
