<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Varchar length for primary keys that are strings
    |--------------------------------------------------------------------------
    |
    | Instead of using incrementing IDs for primary keys, it's generally
    | safer to use random strings. This setting defines how many characters
    | long they will be.
    |
    */

    'string_pk_length' => 20,

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
    | The User model will be moved into it.
    |
    */

    'models_namespace' => 'Models',

    /*
    |--------------------------------------------------------------------------
    | The name of the public directory
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

];
