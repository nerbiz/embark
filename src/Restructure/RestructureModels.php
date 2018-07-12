<?php

namespace Nerbiz\Embark\Restructure;

use Illuminate\Foundation\Console\ClosureCommand;

class RestructureModels extends AbstractRestructure
{
    /**
     * The new namespace of the User model
     * @var string
     */
    protected $modelsNamespace;

    /**
     * The full namespace path of models
     * @var string
     */
    protected $modelsNamespacePath;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->modelsNamespace = config('embark.models_namespace');
        $this->modelsNamespacePath = rtrim(
            app_path(str_replace('\\', '/', $this->modelsNamespace)),
            '/'
        );
    }

    /**
     * Get the list of files that will be edited
     * @return array
     */
    public function getFileList()
    {
        return [
            app_path('User.php'),
            app_path('Http/Controllers/Auth/RegisterController.php'),
            config_path('auth.php'),
            config_path('services.php'),
            base_path('database/factories/UserFactory.php'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function isDoneAlready()
    {
        return (is_readable(sprintf(
            '%s/User.php',
            $this->modelsNamespacePath
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function restructure()
    {
        $userModelPath = app_path('User.php');

        // Create the namespace directory if it doesn't exist yet
        if (! file_exists($this->modelsNamespacePath)) {
            mkdir($this->modelsNamespacePath, 0755, true);
        }

        // Change the namespace usages in the files
        foreach ($this->getFileList() as $path) {
            // Change the namespace in the User file
            if ($path === $userModelPath) {
                $search = 'namespace App;';
                $replace = sprintf('namespace App\\%s;', $this->modelsNamespace);
            }
            // Change the use statements
            else {
                $search = 'App\\User';
                $replace = sprintf('App\\%s\\User', $this->modelsNamespace);
            }

            $fileContents = str_replace($search, $replace, file_get_contents($path));
            file_put_contents($path, $fileContents);
        }

        // Move the User model to the new namespace
        rename(
            $userModelPath,
            $this->modelsNamespacePath . '/User.php'
        );

        return true;
    }
}
