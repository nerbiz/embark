<?php

namespace Nerbiz\Embark\ConsoleMessages;

abstract class AbstractRestructureMessages extends AbstractConsoleMessages
{
    /**
     * Notify that the restructuring has been done already
     * @return void
     */
    public function infoDoneAlready()
    {
        $this->command->info('Restructuring seems to have been done already');
    }

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function infoSucceeded()
    {
        $this->command->info('Restructuring is finished');
    }

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function infoAborted()
    {
        $this->command->info('Restructuring is aborted');
    }
}
