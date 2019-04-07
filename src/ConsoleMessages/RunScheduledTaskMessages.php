<?php

namespace Nerbiz\Embark\ConsoleMessages;

class RunScheduledTaskMessages extends AbstractMessages
{
    /**
     * Inform that 1 or more tasks don't have a description
     * @return void
     */
    public function warnNoDescription(): void
    {
        $this->command->warn('1 or more tasks don\'t have a description,');
        $this->command->warn('you can set a description with: $schedule->call(...)->description(\'text\')');
    }

    /**
     * Inform that a task is running
     * @param string|null $description
     * @return void
     */
    public function infoTaskIsRunning(?string $description): void
    {
        if ($description === null) {
            $this->command->info('Running task...');
        } else {
            $this->command->info(sprintf(
                'Running task \'%s\'...',
                $description
            ));
        }
    }
}
