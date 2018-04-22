<?php

namespace Nerbiz\Embark\Restructure;

class RestructureBase extends AbstractRestructure
{
    /**
     * Get the list of files/directories to exclude from the new Laravel directory
     * @return array
     */
    public function getExcludedList()
    {
        $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');
        $laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');

        // Get the user-defined exclude list, must be an array
        $userExcludedFiles = config('embark.exclude_from_laravel_dir');
        if ($userExcludedFiles === null || ! is_array($userExcludedFiles)) {
            $userExcludedFiles = [];
        }

        return array_unique(array_merge([
            $newPublicDirname,
            $laravelDirname,
            '.idea',
            '.git',
            '.gitattributes',
            '.gitignore'
        ], $userExcludedFiles));
    }

    /**
     * {@inheritdoc}
     */
    public function isDoneAlready()
    {
        // See if the default 'public' directory exists
        return (! is_readable(base_path('public')));
    }

    /**
     * {@inheritdoc}
     */
    public function showDoneAlreadyText()
    {
        parent::showDoneAlreadyText();
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
            ['comment', '- Change the directory and files structure to this:']
        ];

        foreach ($this->getExcludedList() as $path) {
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
        $laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');

        // Check if the Laravel directory to be created, already exists
        if (is_readable(base_path($laravelDirname))) {
            $this->command->error(sprintf(
                "The '%s' directory already exists, can't create the Laravel directory",
                $laravelDirname
            ));

            return false;
        }

        // Add the custom Application class
        $this->createApplicationClass();

        // Update the bootstrap/app.php file
        $this->adjustBootstrapFile();

        // Update the public index.php file
        $this->adjustPublicIndexFile();

        // Update the .gitignore file
        $this->adjustGitignoreFile();

        // Move the files
        $this->moveFilesToLaravelDirectory();

        return true;
    }

    /**
     * Create a custom Application class
     * @return void
     */
    protected function createApplicationClass()
    {
        $generatingNamespace = config('embark.generating_namespace');
        $namespacePath = rtrim(app_path(str_replace('\\', '/', $generatingNamespace)), '/');
        $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');

        // Get the stub contents and adjust it
        $applicationStub = str_replace(
            ['DummyNamespace', 'DummyPublicDirname'],
            ['App\\' . $generatingNamespace, $newPublicDirname],
            file_get_contents(dirname(__FILE__, 3) . '/stubs/Application.stub')
        );

        // Create the namespace directory if it doesn't exist yet
        if (! file_exists($namespacePath)) {
            mkdir($namespacePath, 0755, true);
        }

        // Save the new Application file
        file_put_contents($namespacePath . '/Application.php', $applicationStub);
    }

    /**
     * Adjust the $app variable in bootstrap/app.php
     * @return void
     */
    protected function adjustBootstrapFile()
    {
        $bootstrapFilepath = base_path('bootstrap/app.php');
        $newApplicationClass = 'App\\' . config('embark.generating_namespace') . '\\Application';

        // Adjust the $app variable
        $bootstrapContents = str_replace(
            '$app = new Illuminate\\Foundation\\Application(',
            '$app = new ' . $newApplicationClass . '(',
            file_get_contents($bootstrapFilepath)
        );

        // Update the file
        file_put_contents($bootstrapFilepath, $bootstrapContents);
    }

    /**
     * Adjust the public index.php file
     * @return void
     */
    protected function adjustPublicIndexFile()
    {
        $publicIndexFilepath = public_path('index.php');
        $laravelDirname = config('embark.laravel_directory_name');

        // Adjust the paths
        $indexFileContents = str_replace(
            '__DIR__.\'/../',
            sprintf('dirname(__FILE__, 2) . \'/%s/', $laravelDirname),
            file_get_contents($publicIndexFilepath)
        );

        // Update the file
        file_put_contents($publicIndexFilepath, $indexFileContents);
    }

    /**
     * Update the paths in .gitignore
     * @return void
     */
    protected function adjustGitignoreFile()
    {
        $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');
        $laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');
        $gitignoreFilepath = base_path('.gitignore');

        // Change the Laravel path
        $gitignoreFileContents = preg_replace(
            '~^/(?!public)~m',
            '/' . $laravelDirname . '/',
            file_get_contents($gitignoreFilepath)
        );

        // Change the public path
        $gitignoreFileContents = str_replace(
            '/public/',
            '/' . $newPublicDirname . '/',
            $gitignoreFileContents
        );

        // Update the file
        file_put_contents($gitignoreFilepath, $gitignoreFileContents);
    }

    /**
     * Move the Laravel files to a separate directory
     * @return void
     */
    protected function moveFilesToLaravelDirectory()
    {
        $currentPublicPath = public_path();
        $newPublicDirname = rtrim(config('embark.public_directory_name'), '/');
        $laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');

        // Create the Laravel directory
        mkdir(base_path($laravelDirname), 0755);

        // Rename the public directory, if the new name is different
        if (basename($currentPublicPath) !== $newPublicDirname) {
            rename($currentPublicPath, base_path($newPublicDirname));
        }

        // See which items in the base directory need to be moved
        $moveItems = array_diff(
            scandir(base_path()),
            ['.', '..'],
            $this->getExcludedList()
        );

        // Move the items into the Laravel directory
        foreach ($moveItems as $item) {
            rename(base_path($item), base_path($laravelDirname . '/' . $item));
        }
    }
}
