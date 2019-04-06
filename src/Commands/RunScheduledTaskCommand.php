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
        $runScheduledTaskMessages = app()->make(RunScheduledTaskMessages::class, [
            'command' => $this
        ]);

        // Get the scheduled tasks
        $events = app(Schedule::class)->events();

        // Check the amount of tasks
        if (count($events) > 26) {
            $runScheduledTaskMessages->warnAmountTooHigh(26, count($events));
            $runScheduledTaskMessages->infoAborted();
            return false;
        }

        $choices = [];
        $tasks = [];
        foreach ($events as $key => $event) {
            // Show a notice as description, if there is no description
            if (trim($event->description) === '') {
                $description = 'No description (set it with ->description() on the task)';
            } else {
                $description = $event->description;
            }

            // Use letters as keys, so that the choice returns those
            // Non-associative arrays return the value instead (in this case, the description)
            $letter = chr(97 + $key);
            $choices[$letter] = $description;
            $tasks[$letter] = $event;
        }

        // Ask which task needs to be run
        $chosen = $this->choice('Which scheduled task should be run?', $choices);

        // Run the task
        $runScheduledTaskMessages->infoTaskIsRunning();
        $tasks[$chosen]->run($this->laravel);

        $runScheduledTaskMessages->infoSucceeded();
    }
}
