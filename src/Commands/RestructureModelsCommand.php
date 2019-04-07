<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\Command;
use Nerbiz\Embark\ConsoleMessages\RestructureModelsMessages;
use Nerbiz\Embark\Restructure\RestructureModels;

class RestructureModelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embark:models-namespace';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->description = sprintf(
            'Create the App\%s namespace and move User to it',
            config('embark.models_namespace')
        );

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $restructureModels = app()->make(RestructureModels::class);
        $restructureModelsMessages = app()->make(
            RestructureModelsMessages::class,
            ['command' => $this]
        );

        // Check if the restructuring has been done already
        if ($restructureModels->isDoneAlready()) {
            $restructureModelsMessages->infoDoneAlready();
            $restructureModelsMessages->infoAborted();
            return false;
        }

        // Ask for confirmation before continuing
        $restructureModelsMessages->infoConfirmation($restructureModels->getFileList());
        $confirmed = $restructureModelsMessages->askConfirmation();

        // Show 'aborting' text when the user didn't confirm
        if ($confirmed !== true) {
            $restructureModelsMessages->infoAborted();
            return false;
        }

        // Perform the restructuring
        $succeeded = $restructureModels->restructure();

        // Show the 'aborting' text, if something went wrong
        if ($succeeded === true) {
            $restructureModelsMessages->infoSucceeded();
            $restructureModelsMessages->commentModelCreation();
        } else {
            $restructureModelsMessages->infoAborted();
        }
    }
}
