<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\Command;
use Nerbiz\Embark\ConsoleMessages\RestructureBaseMessages;
use Nerbiz\Embark\Restructure\RestructureBase;

class RestructureBaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embark:restructure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Laravel and public files to separate directories';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $restructureBase = app()->make(RestructureBase::class);
        $restructureBaseMessages = app()->make(
            RestructureBaseMessages::class,
            ['command' => $this]
        );

        // Check if the restructuring has been done already
        if ($restructureBase->isDoneAlready()) {
            $restructureBaseMessages->infoDoneAlready();
            $restructureBaseMessages->infoAborted();
            return false;
        }

        // Ask for confirmation before continuing
        $restructureBaseMessages->infoConfirmation($restructureBase->getExcludedList());
        $confirmed = $restructureBaseMessages->askConfirmation();

        // Show 'aborting' text when the user didn't confirm
        if ($confirmed !== true) {
            $restructureBaseMessages->infoAborted();
            return false;
        }

        // Perform the restructuring
        $succeeded = $restructureBase->restructure();

        // Show the 'aborting' text, if something went wrong
        if ($succeeded === true) {
            $restructureBaseMessages->infoSucceeded();
            $restructureBaseMessages->commentChangeDir();
        } else {
            $restructureBaseMessages->infoAborted();
        }
    }
}
