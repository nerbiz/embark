<?php

namespace Nerbiz\Embark\ConsoleMessages;

class RunScheduledTaskMessages extends AbstractMessages
{
    /**
     * Warn that there are too many tasks
     * @param int $max The maximum amount of supported tasks
     * @param int $current The current amount of tasks
     * @return void
     */
    public function warnAmountTooHigh(int $max, int $current)
    {
        $this->command->warn(sprintf(
            'Only %s tasks are currently supported, you currently have %d',
            $max,
            $current
        ));
    }

    /**
     * Inform that a task is running
     * @return void
     */
    public function infoTaskIsRunning()
    {
        $this->command->info('Running task...');
    }
}
