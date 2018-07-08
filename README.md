# Embark

A flying start for Laravel projects.

There were some things that I did/used with new Laravel projects, so putting those things in a package speeds up that process. Maybe you'll find it useful as well. This package is in the public domain (using the [Unlicense](http://unlicense.org/)), so go ahead and use it for anything.

## Installation

The intended Laravel version is 5.6, I haven't tested it in previous versions.

Include this project with [Composer](https://getcomposer.org/):  
```composer require nerbiz/embark 0.*```

The service provider will be autodiscovered, but for completeness, the service provider file is `Nerbiz\Embark\EmbarkServiceProvider`. There is no (need for a) Facade, but who knows what the future brings.

Publish the config file:  
```php artisan vendor:publish --tag=embark-config```

Publish some basic views:
```php artisan vendor:publish --tag=embark-views```

## Commands

These are the Artisan commands included in this package:

* `embark:empty-class`: Creates an empty class with only a constructor. The namespace for it can be configured in `config/embark.php`.
* `embark:migration`: Works in the same way as (extends) `make:migration`, but uses custom stubs, including the MigrationHelper of this package.
* `embark:model`: Works in the same way as (extends) `make:model`, but uses custom namespace and embark:migration instead of make:migration. The namespace for it can be configured in `config/embark.php`.
* `embark:models-namespace`: Create the App\Models namespace and move User to it, and update files that use the User model. Namespace name can be defined in `config/embark.php`.
* `embark:restructure`: Adjusts the directory structure, creates a 'laravel' directory next to the public directory.
* `embark:webpack`: Intended to use with `embark:restructure`, this overwrites the webpack.mix.js file, using the new public directory path.

Explanation for `embark:restructure`:  
I guess this is mostly useful for shared hosting, or other environments with limited control.

Usually, the public directory is called 'public_html', not 'public' as in Laravel. There are usually also a number of files and directories next to the public directory, like things for stats, FTP, SSH, mailboxes etc. I don't prefer to mix those with Laravel files, so my idea was to move all those files to a separate 'laravel' directory. The end result is a 'laravel' and 'public_html' directory, next to each other.

Paths have also been taken care of in this command, so you can just start building.

## Usage

### Migration helper

* `foreign(Blueprint $table, $foreignKey, $foreignTable = null, $onUpdate = null, $onDelete = null)`  
Adds a foreign key to an existing table column.  
Default settings for the 'on update/delete' actions are in `config/embark.php`.  
This method assumes that 'category_id' references 'id' on 'categories', which is why this method is shorter than the default `$table->foreign()->refereces...`.
* `dropForeign(Blueprint $table, ...$columns)`  
Like the usual dropForeign(), only this supports multiple columns in the same call. It wraps a column name in an array, so that it uses Laravel's naming convention, [see the docs about this](https://laravel.com/docs/5.6/migrations#foreign-key-constraints).
* `dropForeignColumn(Blueprint $table, ...$columns)`  
Works just like dropForeignColumn, but this method also drops the column itself. Multiple columns can be passed in the same call.

## Contributing

Please do a pull request, if you have some improvements in mind.

## License

This project uses the [Unlicense](http://unlicense.org/).
