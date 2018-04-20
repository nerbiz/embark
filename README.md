# Embark
A jumpstart for Laravel projects.

There were some things that I did/used with new Laravel projects, so putting those things in a package speeds up that process. Maybe you'll find it useful as well. This package is in the public domain (using the [Unlicense](http://unlicense.org/)), so go ahead and use it for anything.

## This is still a work in progress.
## I'd prefer to make a wiki for this, but all in good time.

---

## Installation
The intended Laravel version is 5.6, I haven't tested it in previous versions.

Include this project with [Composer](https://getcomposer.org/):  
```composer require nerbiz/embark```

The service provider will be autodiscovered, but for completeness, the service provider file is `Nerbiz\Embark\EmbarkServiceProvider`. There is no (need for a) Facade, but who knows what the future brings.

Publish the config file:  
```php artisan vendor:publish --tag=embark-config```

Publishing the .scss files is optional, because you can also import them from the vendor directory. See the 'Usage: SCSS' section for more info. The files will be published to `resources/assets/sass/embark`.  
```php artisan vendor:publish --tag=embark-scss```

## Commands
These are the Artisan commands included in this package:
* `embark:empty-class`: Creates an empty class with only a constructor. The namespace for it can be configured in `config/embark.php`.
* `embark:migration`: Works in the same way as (extends) `make:migration`, but uses custom stubs, including the MigrationHelper of this package.

## Usage
### Migration helper
* `primaryString(Blueprint $table, $columnName = 'id')`  
Adds a primary key as a varchar column ('id') to a table, with a varchar length defined in `config/embark.php`.
* `foreignString(Blueprint $table, $foreignKey, $foreignTable = null, $onUpdate = null, $onDelete = null)`  
Adds a varchar column to a table and makes it a foreign key, with obviously the same length as `primaryString()`.
* `foreign(Blueprint $table, $foreignKey, $foreignTable = null, $onUpdate = null, $onDelete = null)`  
Like `foreignString()`, but adds a foreign key to an existing table column. This method it shorter than the default `$table->foreign()->refereces...`.  
Default settings for the 'on update/delete' actions are in `config/embark.php`.  
This method assumes that 'category_id' references 'id' on 'categories', which is why this method is shorter.

### Database class
* `makeUniquePrimaryString($modelClass, $column = 'id')`  
Creates a unique string for a (primary key) column, using the varchar length defined in `config/embark.php`. It is unique per column, not for all columns/tables. So theoretically it's possible that 'table_1.id' contains the same value as 'table_2.id'.

### SCSS
The below shows the paths for including the .scss files from the vendor directory. The files are intended for Bootstrap 4, but they're also useful without it. This is what the app.scss file would look like:

```scss
@import '../../../vendor/nerbiz/embark/scss/before-vendor';

// ...vendors, like Bootstrap 4

@import '../../../vendor/nerbiz/embark/scss/after-vendor';

// ...the rest of your scss
```

## Contributing
Please do a pull request, if you have some improvements in mind.

## License
This project uses the [Unlicense](http://unlicense.org/).
