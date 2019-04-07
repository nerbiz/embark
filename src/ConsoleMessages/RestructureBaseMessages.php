<?php

namespace Nerbiz\Embark\ConsoleMessages;

use Illuminate\Console\Command;

class RestructureBaseMessages extends AbstractRestructureMessages
{
    /**
     * The name of the laravel directory to be created
     * @var string
     */
    protected $laravelDirname;

    /**
     * The new name of the public directory
     * @var string
     */
    protected $newPublicDirname;

    /**
     * The namespace of generated files (without App)
     * @var string
     */
    protected $generatingNamespace;

    /**
     * {@inheritdoc}
     */
    public function __construct(Command $command)
    {
        parent::__construct($command);

        $this->laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');
        $this->newPublicDirname = rtrim(config('embark.public_directory_name'), '/');
        $this->generatingNamespace = config('embark.generating_namespace');
    }

    /**
     * {@inheritdoc}
     */
    public function infoDoneAlready(): void
    {
        parent::infoDoneAlready();

        $this->command->comment("The 'public' directory doesn't exist in the base directory,");
        $this->command->comment(sprintf(
            "and/or the '%s' directory already exists",
            $this->laravelDirname
        ));
    }

    /**
     * Show a confirmation text
     * @param array $excludedList The list of excluded files to describe
     * @return void
     */
    public function infoConfirmation($excludedList): void
    {
        $this->warnDestructive();
        $this->command->info('These are the actions that will be performed:');
        $this->command->comment('- Change the directory and files structure to this:');

        foreach ($excludedList as $path) {
            $this->command->comment(sprintf('  |-- %s', $path));
        }

        $this->command->comment(sprintf(
            '- Add %s\\Application, specifies new public path',
            $this->generatingNamespace
        ));

        $this->command->comment(sprintf(
            '- Make the $app variable in bootstrap/app.php an instance of %s\\Application',
            $this->generatingNamespace
        ));

        $this->command->comment(sprintf(
            '- Change the \'vendor\' and \'bootstrap\' paths in %s/index.php',
            $this->newPublicDirname
        ));

        $this->command->comment(sprintf(
            '- Change the Laravel (%s) and public (%s) paths in .gitignore',
            $this->laravelDirname,
            $this->newPublicDirname
        ));
    }

    /**
     * Notify about changing directory after moving
     * @return void
     */
    public function commentChangeDir(): void
    {
        $this->command->comment(sprintf(
            "You can now type 'cd %s'",
            $this->laravelDirname
        ));
    }
}
