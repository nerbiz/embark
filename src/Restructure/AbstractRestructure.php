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
     * Perform the restructuring operations
     * @return boolean Indicates if the restructuring succeeded or not
     */
    abstract public function restructure();

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }
}
