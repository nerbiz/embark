<?php

namespace Nerbiz\Embark\Restructure;

use Illuminate\Foundation\Console\ClosureCommand;

class RestructureBase implements RestructureInterface
{
    /**
     * @var ClosureCommand
     */
    protected $closureCommand;

    /**
     * Whether or not the user confirmed to continue
     * @var boolean
     */
    protected $confirmed;

    /**
     * @param ClosureCommand $closureCommand
     */
    public function __construct(ClosureCommand $closureCommand)
    {
        $this->closureCommand = $closureCommand;
    }

    /**
     * Check if the restructuring is done already
     * @return boolean
     */
    public function isDoneAlready()
    {
        // See if the default 'public' directory exists
        return (! is_readable(base_path('public')));
    }

    /**
     * Notify that the restructuring has been done already
     * @return void
     */
    public function showDoneAlreadyText()
    {
        $this->closureCommand->info('Restructuring seems to have been done already');
        $this->closureCommand->comment("The 'public' directory doesn't exist in the base directory");
    }

    /**
     * Show some text that confirms aborting
     * @return void
     */
    public function showAbortingText()
    {
        $this->closureCommand->info('Restructuring is aborted');
    }

    /**
     * Show a confirmation text, before continuing
     * @return void
     */
    public function showConfirmationText()
    {
        $texts = [
            ['error',   'Warning: this is a potentially destructive operation'],
            ['error',   'and should only be done in new Laravel projects'],
            ['info',    'These are the actions that will be performed:'],
            ['comment', '- Change the directory and files structure to this:'],
            ['comment', '  |-- ' . sprintf('%s/', config('embark.laravel_directory_name'))],
            ['comment', '  |-- ' . sprintf('%s/', config('embark.public_directory_name'))]
        ];

        foreach (config('embark.exclude_from_laravel_dir') as $path) {
            $texts[] = ['comment', sprintf('  |-- %s', $path)];
        }

        $texts = array_merge_recursive($texts, [
            ['comment', sprintf(
                '- Add %s\\Application, specifies new public path',
                config('embark.generating_namespace')
            )],
            ['comment', sprintf(
                '- Make the $app variable in bootstrap/app.php an instance of %s\\Application',
                config('embark.generating_namespace')
            )],
            ['comment', sprintf(
                '- Change the \'vendor\' and \'bootstrap\' paths in %s/index.php',
                config('embark.public_directory_name')
            )],
            ['comment', sprintf(
                '- Change the Laravel (%s) and public (%s) paths in .gitignore',
                config('embark.laravel_directory_name'),
                config('embark.public_directory_name')
            )]
        ]);

        // Output all the messages
        foreach ($texts as $text) {
            list($type, $message) = $text;
            $this->closureCommand->{$type}($message);
        }
    }

    /**
     * Ask for confirmation to continue
     * @return boolean
     */
    public function askForConfirmation()
    {
        $this->confirmed = $this->closureCommand->confirm('Would you like to continue?', false);
        return $this->confirmed;
    }

    /**
     * {@inheritdoc}
     */
    public function restructure()
    {
        //
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }
}
