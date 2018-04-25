<?php

namespace Nerbiz\Embark\Restructure;

class RestructureBase extends AbstractRestructure
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
     * The full namespace path of generated files
     * @var string
     */
    protected $generatingNamespacePath;

    /**
     * The user-defined list of files to exclude from the Laravel directory
     * @var array
     */
    protected $userExcludedFiles;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->laravelDirname = rtrim(config('embark.laravel_directory_name'), '/');
        $this->newPublicDirname = rtrim(config('embark.public_directory_name'), '/');
        $this->generatingNamespace = config('embark.generating_namespace');
        $this->generatingNamespacePath = rtrim(
            app_path(str_replace('\\', '/', $this->generatingNamespace)),
            '/'
        );
        $this->userExcludedFiles = config('embark.exclude_from_laravel_dir');

        // The user-defined exclude list must be an array
        if ($this->userExcludedFiles === null || ! is_array($this->userExcludedFiles)) {
            $this->userExcludedFiles = [];
        }
    }

    /**
     * Get the list of files/directories to exclude from the new Laravel directory
     * @return array
     */
    public function getExcludedList()
    {
        return array_unique(array_merge([
            $this->laravelDirname,
            $this->newPublicDirname,
            '.idea',
            '.git',
            '.gitattributes',
            '.gitignore'
        ], $this->userExcludedFiles));
    }

    /**
     * {@inheritdoc}
     */
    public function isDoneAlready()
    {
        // See if the default 'public' directory exists
        return (is_readable(base_path($this->laravelDirname)) || ! is_readable(base_path('public')));
    }

    /**
     * {@inheritdoc}
     */
    public function restructure()
    {
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
        // Get the stub contents and adjust it
        $applicationStub = str_replace(
            ['DummyNamespace', 'DummyPublicDirname'],
            ['App\\' . $this->generatingNamespace, $this->newPublicDirname],
            file_get_contents(dirname(__FILE__, 3) . '/stubs/Application.stub')
        );

        // Create the namespace directory if it doesn't exist yet
        if (! file_exists($this->generatingNamespacePath)) {
            mkdir($this->generatingNamespacePath, 0755, true);
        }

        // Save the new Application file
        file_put_contents($this->generatingNamespacePath . '/Application.php', $applicationStub);
    }

    /**
     * Adjust the $app variable in bootstrap/app.php
     * @return void
     */
    protected function adjustBootstrapFile()
    {
        $bootstrapFilepath = base_path('bootstrap/app.php');
        $newApplicationClass = 'App\\' . $this->generatingNamespace . '\\Application';

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

        // Adjust the paths
        $indexFileContents = str_replace(
            '__DIR__.\'/../',
            sprintf('dirname(__FILE__, 2) . \'/%s/', $this->laravelDirname),
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
        $gitignoreFilepath = base_path('.gitignore');

        // Change the Laravel path
        $gitignoreFileContents = preg_replace(
            '~^/(?!public)~m',
            '/' . $this->laravelDirname . '/',
            file_get_contents($gitignoreFilepath)
        );

        // Change the public path
        $gitignoreFileContents = str_replace(
            '/public/',
            '/' . $this->newPublicDirname . '/',
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

        // Create the Laravel directory
        mkdir(base_path($this->laravelDirname), 0755);

        // Rename the public directory, if the new name is different
        if (basename($currentPublicPath) !== $this->newPublicDirname) {
            rename($currentPublicPath, base_path($this->newPublicDirname));
        }

        // See which items in the base directory need to be moved
        $moveItems = array_diff(
            scandir(base_path()),
            ['.', '..'],
            $this->getExcludedList()
        );

        // Move the items into the Laravel directory
        foreach ($moveItems as $item) {
            rename(base_path($item), base_path($this->laravelDirname . '/' . $item));
        }
    }
}
