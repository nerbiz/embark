<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\Command;
use Nerbiz\Embark\ConsoleMessages\ClearLogsMessages;

class ClearLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embark:clear-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all *.log files from the logs directory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clearLogsMessages = app()->make(
            ClearLogsMessages::class,
            ['command' => $this]
        );

        $clearLogsMessages->infoDescribe();
        $confirmed = $clearLogsMessages->askConfirmation();

        // Show 'aborting' text when the user didn't confirm
        if ($confirmed !== true) {
            $clearLogsMessages->infoAborted();
            return false;
        }

        // Delete the log files
        foreach (glob(storage_path('logs/*.log')) as $logFile) {
            unlink($logFile);
        }

        $clearLogsMessages->infoSucceeded();
    }
}
