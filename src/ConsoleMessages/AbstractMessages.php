<?php

namespace Nerbiz\Embark\ConsoleMessages;

use Illuminate\Console\Command;

abstract class AbstractMessages
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * @param Command $command
     */
    public function __construct(Command $command)
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
     * @return bool Whether the user confirmed or not
     */
    public function askConfirmation(): bool
    {
        $question = "Would you like to continue? (type 'yes' to confirm)";
        return ($this->command->ask($question) === 'yes');
    }

    /**
     * Inform that the command has succeeded
     * @return void
     */
    public function infoSucceeded()
    {
        $this->command->info('Finished');
    }

    /**
     * Inform that the command has been aborted
     * @return void
     */
    public function infoAborted()
    {
        $this->command->info('Aborted');
    }
}
