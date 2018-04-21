<?php

namespace Nerbiz\Embark\Restructure;

use Illuminate\Foundation\Console\ClosureCommand;

class RestructureBase implements RestructureInterface
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
        $this->command->info('Restructuring seems to have been done already');
        $this->command->error("The 'public' directory doesn't exist in the base directory");
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
            $this->command->{$type}($message);
        }
    }

    /**
     * Ask for confirmation to continue
     * @return boolean
     */
    public function askForConfirmation()
    {
        $question = "Would you like to continue? (type 'yes' to confirm)";
        $this->confirmed = ($this->command->ask($question) === 'yes');
        return $this->confirmed;
    }

    /**
     * {@inheritdoc}
     */
    public function restructure()
    {
        $currentPublicPath = public_path();
        $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');
        $laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');

        // Check if the Laravel directory to be created, already exists
        if (is_readable(base_path($laravelDirname))) {
            $this->command->error(sprintf(
                "The '%s' directory already exists, can't create the Laravel directory",
                $laravelDirname
            ));

            return false;
        }

        // Create the Laravel directory
        mkdir(base_path($laravelDirname));

        // Rename the public directory, if the new name is different
        if (basename($currentPublicPath) !== $newPublicDirname) {
            rename($currentPublicPath, base_path($newPublicDirname));
        }

        // See which items in the base directory need to be moved
        $baseContents = array_diff(scandir(base_path()), ['.', '..']);
        $moveItems = array_diff($baseContents, config('embark.exclude_from_laravel_dir'));
        // The public and Laravel directory are also excluded
        $moveItems = array_diff($moveItems, [$newPublicDirname, $laravelDirname]);

        // Move the items into the Laravel directory
        foreach ($moveItems as $item) {
            rename(base_path($item), base_path($laravelDirname . '/' . $item));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function showSucceededText()
    {
        $this->command->info('Restructuring finished');
    }

    /**
     * {@inheritdoc}
     */
    public function showFailedText()
    {
        $this->command->info('Restructuring is aborted');
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }
}
