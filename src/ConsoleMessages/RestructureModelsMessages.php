<?php

namespace Nerbiz\Embark\ConsoleMessages;

use Illuminate\Foundation\Console\ClosureCommand;

class RestructureModelsMessages extends AbstractRestructureMessages
{
    /**
     * The new namespace for models
     * @var string
     */
    protected $modelsNamespace;

    /**
     * @param ClosureCommand $command
     */
    public function __construct(ClosureCommand $command)
    {
        parent::__construct($command);

        $this->modelsNamespace = config('embark.models_namespace');
    }

    /**
     * {@inheritdoc}
     */
    public function infoDoneAlready()
    {
        parent::infoDoneAlready();

        $this->command->comment(sprintf(
            "The User model is already in the 'App\%s' namespace",
            $this->modelsNamespace
        ));
    }

    /**
     * Show a confirmation text
     * @param array $fileList The list of applicable files to describe
     * @return void
     */
    public function infoConfirmation($fileList)
    {
        $this->warnDestructive();
        $this->command->info('These are the actions that will be performed:');
        $this->command->comment(sprintf(
            "- Create the 'App\%s' namespace if it doesn't exist yet",
            $this->modelsNamespace
        ));
        $this->command->comment(sprintf(
            "- Move the User model to the 'App\%s' namespace",
            $this->modelsNamespace
        ));
        $this->command->comment('- Change the User namespace in these files:');

        foreach ($fileList as $path) {
            $this->command->comment(sprintf('  %s', $path));
        }
    }

    /**
     * Notify about creating new models
     * @return void
     */
    public function commentModelCreation()
    {
        $this->command->comment(sprintf(
            "The 'artisan embark:model YourModel' command uses the 'App\%s' namespace",
            $this->modelsNamespace
        ));
    }
}
