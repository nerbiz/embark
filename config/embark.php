<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fix for error:
    | 'Specified key was too long; max key length is 767 bytes'
    |--------------------------------------------------------------------------
    |
    | utf8mb4 uses 4 bytes per character, so with 767 total bytes, that
    | means max 767 / 4 = 191.75 bytes (characters).
    | Applies to MySQL < 5.7.7 and MariaDB < 10.2.2 (InnoDB engine), so only
    | enable this if applicable.
    | See 'Index Lengths & MySQL / MariaDB'
    | on https://laravel.com/docs/master/migrations#creating-indexes
    |
    */

    'string_length_fix' => true,

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

];
