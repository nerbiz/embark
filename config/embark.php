<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default values for 'on update' and 'on delete' actions
    |--------------------------------------------------------------------------
    |
    | Decide what needs to happen to foreign keys, when a row of a parent
    | table changes.
    |
    */

    'default_on_update' => 'cascade',
    'default_on_delete' => 'restrict',

    /*
    |--------------------------------------------------------------------------
    | Namespace for class generating
    |--------------------------------------------------------------------------
    |
    | This namespace is used for generated classes. Please note that
    | backslashes need to be escaped: 'Main\\Sub'.
    |
    */

    'generating_namespace' => 'Main',

    /*
    |--------------------------------------------------------------------------
    | Namespace for the models
    |--------------------------------------------------------------------------
    |
    | This namespace is used for creating a separate models namespace.
    | The User model will be moved into it. Please note that backslashes
    | need to be escaped: 'Models\\Sub'.
    |
    */

    'models_namespace' => 'Models',

    /*
    |--------------------------------------------------------------------------
    | The name of the new Laravel and public directory
    |--------------------------------------------------------------------------
    |
    | For the command that moves all Laravel and public files to separate
    | directories. Also used for adjusting paths accordingly afterwards.
    |
    */

    'laravel_directory_name' => 'laravel',
    'public_directory_name' => 'public_html',

    /*
    |--------------------------------------------------------------------------
    | Files to keep in place, when moving the Laravel directory
    |--------------------------------------------------------------------------
    |
    | Add the file/directory names that need to stay in the main directory.
    | All other files will be moved to a separate Laravel directory.
    |
    | Always excluded:
    | /laravel     (the separate Laravel directory itself,
    |               created before moving files into it)
    | /public_html (the renamed public directory, renamed before moving)
    | .idea
    | .git
    | .gitattributes
    | .gitignore
    |
    */

    'exclude_from_laravel_dir' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Full path to the custom stubs
    |--------------------------------------------------------------------------
    |
    | Set the path to custom stubs to use for model or migation creation,
    | for example. If a stub is not found at that path, the one in this
    | package will be used.
    |
    */

    'stubs_path' => resource_path('stubs'),

];
