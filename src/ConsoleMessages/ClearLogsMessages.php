<?php

namespace Nerbiz\Embark\ConsoleMessages;

class ClearLogsMessages extends AbstractMessages
{
    /**
     * Describe what will happen
     * @return void
     */
    public function infoDescribe()
    {
        $this->command->info(sprintf(
            'All *.log files in %s will be deleted',
            storage_path('logs')
        ));
    }
}
