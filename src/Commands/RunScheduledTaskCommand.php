<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Nerbiz\Embark\Console\AssociativeChoiceQuestion;
use Nerbiz\Embark\ConsoleMessages\RunScheduledTaskMessages;
use Symfony\Component\Console\Question\ChoiceQuestion;

class RunScheduledTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embark:run-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a scheduled task immediately';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $runScheduledTaskMessages = app()->make(
            RunScheduledTaskMessages::class,
            ['command' => $this]
        );

        // Get the scheduled tasks
        $events = app(Schedule::class)->events();

        $choices = [];
        $hasNoDescription = false;
        foreach ($events as $event) {
            // Show a notice as description, if there is no description
            if (trim($event->description) === '') {
                $description = '(No description)';
                $hasNoDescription = true;
            } else {
                $description = $event->description;
            }

            // Add the description to choose from
            $choices[] = $description;
        }

        // Add a cancel option
        $choices['c'] = 'Cancel';

        // Warn when 1 or more tasks don't have a description
        if ($hasNoDescription === true) {
            $runScheduledTaskMessages->warnNoDescription();
        }

        // Ask which task needs to be run
        $chosen = $this->choice('Which scheduled task should be run?', $choices);

        // The cancel option has been chosen
        if ($chosen === 'c') {
            $runScheduledTaskMessages->infoAborted();
            return false;
        }

        // Run the task
        $chosenTask = $events[$chosen];
        $runScheduledTaskMessages->infoTaskIsRunning($chosenTask->description);
        $chosenTask->run($this->laravel);

        $runScheduledTaskMessages->infoSucceeded();
    }
}
