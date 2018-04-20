<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Foundation\Console\ClosureCommand;

class RestructureCommand
{
    /**
     * @var ClosureCommand
     */
    protected $command;

    /**
     * Whether or not the user confirmed to continue
     * @var boolean
     */
    protected $confirmed;

    /**
     * @param ClosureCommand $command
     */
    public function __construct(ClosureCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Check if the restructuring is done already
     * @return boolean
     */
    public function doneAlready()
    {
        // See if the default 'public' directory exists
        return (! is_readable(base_path('public')));
    }

    /**
     * Notify about the restructuring being done already
     * @return void
     */
    public function notifyDoneAlready()
    {
        $this->command->info('Restructuring seems to have been done already');
        $this->command->comment("The 'public' directory doesn't exist in the base directory");
    }

    /**
     * Show a warning about this command
     * @return void
     */
    public function showWarning()
    {
        $this->command->error('Warning: this is a potentially destructive operation');
        $this->command->error('and should only be done in new Laravel projects');

        $this->command->info('These are the actions that will be performed:');
    }

    /**
     * Describe the new files/directories structure
     * @return void
     */
    public function describeChangeStructure()
    {
        $this->command->comment('- Change the directory and files structure to this:');
        $this->command->comment('  |-- ' . sprintf('%s/', config('embark.laravel_directory_name')));
        $this->command->comment('  |-- ' . sprintf('%s/', config('embark.public_directory_name')));

        foreach (config('embark.exclude_from_laravel_dir') as $path) {
            $this->command->comment(sprintf(
                '  |-- %s',
                $path
            ));
        }
    }

    /**
     * Describe the new Application class
     * @return void
     */
    public function describeApplicationClass()
    {
        $this->command->comment(sprintf(
            '- Add %s\\Application, specifies new public path',
            config('embark.generating_namespace')
        ));
    }

    /**
     * Describe the new $app variable
     * @return void
     */
    public function describeAppVariable()
    {
        $this->command->comment(sprintf(
            '- Make the $app variable in bootstrap/app.php an instance of %s\\Application',
            config('embark.generating_namespace')
        ));
    }

    /**
     * Describe the changed paths in the public index.php
     * @return void
     */
    public function describeIndexPaths()
    {
        $this->command->comment(sprintf(
            '- Change the \'vendor\' and \'bootstrap\' paths in %s/index.php',
            config('embark.public_directory_name')
        ));
    }

    /**
     * Describe the changed paths in the public index.php
     * @return void
     */
    public function describeGitignorePaths()
    {
        $this->command->comment(sprintf(
            '- Change the Laravel (%s) and public (%s) paths in .gitignore',
            config('embark.laravel_directory_name'),
            config('embark.public_directory_name')
        ));
    }

    /**
     * Describe the moving of the User model
     * @return void
     */
    public function describeModelMoving()
    {
        $this->command->comment('- Move app/User.php to app/Models/User.php');
    }

    /**
     * Ask for confirmation to continue
     * @return boolean
     */
    public function askForConfirmation()
    {
        $this->confirmed = $this->command->confirm('Would you like to continue?', false);
        return $this->confirmed;
    }

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function showAbortingText()
    {
        $this->command->info('Restructuring is aborted');
    }

    /**
     * Wrapper function for all the console messages
     * @return void
     */
    public function showConfirmationText()
    {
        $this->showWarning();
        $this->describeChangeStructure();
        $this->describeApplicationClass();
        $this->describeAppVariable();
        $this->describeIndexPaths();
        $this->describeGitignorePaths();
        $this->describeModelMoving();
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }
}
