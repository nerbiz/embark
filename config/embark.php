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
    | The name of the public directory
    |--------------------------------------------------------------------------
    |
    | For the command that moves all Laravel and public files to separate
    | directories. Also used for adjusting paths accordingly afterwards.
    |
    */

    'laravel_directory_name' => 'laravel',
    'public_directory_name' => 'public_html',

];
