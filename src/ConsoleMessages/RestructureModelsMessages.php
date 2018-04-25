<?php

namespace Nerbiz\Embark\ConsoleMessages;

class RestructureModelsMessages extends AbstractRestructureMessages
{
    /**
     * {@inheritdoc}
     */
    public function infoDoneAlready()
    {
        parent::infoDoneAlready();

        $this->command->comment(sprintf(
            "The User model is already in the '%s' namespace",
            config('embark.models_namespace')
        ));
    }

    /**
     * Show a confirmation text
     * @param array $fileList The list of applicable files to describe
     * @return void
     */
    public function infoConfirmation($fileList)
    {
        $modelsNamespace = config('embark.models_namespace');

        $this->warnDestructive();
        $this->command->info('These are the actions that will be performed:');
        $this->command->comment(sprintf(
            "- Create the 'App\%s' namespace if it doesn't exist yet",
            $modelsNamespace
        ));
        $this->command->comment(sprintf(
            "- Move the User model to the 'App\%s' namespace",
            $modelsNamespace
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
            "You can use 'php artisan make:model %s/YourModel' from now on",
            str_replace('\\', '/', config('embark.models_namespace'))
        ));
    }
}
