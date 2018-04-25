<?php

namespace Nerbiz\Embark\ConsoleMessages;

class RestructureBaseMessages extends AbstractRestructureMessages
{
    /**
     * {@inheritdoc}
     */
    public function infoDoneAlready()
    {
        parent::infoDoneAlready();

        $this->command->comment("The 'public' directory doesn't exist in the base directory");
        $this->command->comment(sprintf(
            "And/or: The '%s' directory already exists",
            config('embark.laravel_directory_name')
        ));
    }

    /**
     * Show a confirmation text
     * @param array $excludedList The list of excluded files to describe
     * @return void
     */
    public function infoConfirmation($excludedList)
    {
        $this->warnDestructive();
        $this->command->info('These are the actions that will be performed:');
        $this->command->comment('- Change the directory and files structure to this:');

        foreach ($excludedList as $path) {
            $this->command->comment(sprintf('  |-- %s', $path));
        }

        $this->command->comment(sprintf(
            '- Add %s\\Application, specifies new public path',
            config('embark.generating_namespace')
        ));

        $this->command->comment(sprintf(
            '- Make the $app variable in bootstrap/app.php an instance of %s\\Application',
            config('embark.generating_namespace')
        ));

        $this->command->comment(sprintf(
            '- Change the \'vendor\' and \'bootstrap\' paths in %s/index.php',
            config('embark.public_directory_name')
        ));

        $this->command->comment(sprintf(
            '- Change the Laravel (%s) and public (%s) paths in .gitignore',
            config('embark.laravel_directory_name'),
            config('embark.public_directory_name')
        ));
    }

    /**
     * Notify about changing directory after moving
     * @return void
     */
    public function commentChangeDir()
    {
        $this->command->comment(sprintf(
            "You can now type 'cd %s'",
            config('embark.laravel_directory_name')
        ));
    }
}
