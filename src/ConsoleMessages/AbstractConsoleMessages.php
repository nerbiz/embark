<?php

namespace Nerbiz\Embark\ConsoleMessages;

use Illuminate\Foundation\Console\ClosureCommand;

abstract class AbstractConsoleMessages
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
     * Warn about a potentially destructive operation
     * @return void
     */
    public function warnDestructive()
    {
        $this->command->error('This is a potentially destructive operation');
    }

    /**
     * Warn that the operation should only be done in new projects
     * @return void
     */
    public function warnOnlyOnNew()
    {
        $this->command->error('This should only be done in new Laravel projects');
    }

    /**
     * Ask for confirmation to continue
     * @return boolean Whether the user confirmed or not
     */
    public function askConfirmation()
    {
        $question = "Would you like to continue? (type 'yes' to confirm)";
        return ($this->command->ask($question) === 'yes');
    }
}
