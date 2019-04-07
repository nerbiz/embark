<?php

namespace Nerbiz\Embark\ConsoleMessages;

abstract class AbstractRestructureMessages extends AbstractMessages
{
    /**
     * Notify that the restructuring has been done already
     * @return void
     */
    public function infoDoneAlready(): void
    {
        $this->command->info('Restructuring seems to have been done already');
    }
}
