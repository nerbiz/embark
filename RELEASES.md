# Release notes

## 0.11.0

* Removed the .scss files, moving it to a frontend (NPM) package.

## 0.10.0

* Some basic views can now be published from the service provider.

## 0.9.0

* Added MigrationHelper::dropForeign() and MigrationHelper::dropForeignColumn().
* Improved the migration stub files.
* Renamed the 'move-models' command to 'models-namespace'.

## 0.8.0

* Improved Bootstrap spacer variables format.
* Removed all the primary/foreign keys as strings functionality, because it's bad for performance.

## 0.7.0

* Added Database::validateString(), for checking string column validity, according to the primary string column format.
* Added a fix for the 'max key length is 767 bytes' error (optional, defined in config), which occurs in some DB environments.

## 0.6.3

* Fixed: after creating a new Controllers namespace, the path to the webpack.mix.stub file was invalid.

## 0.6.2

* Changed the description line of this project.
* Improved a comment in the config file.

## 0.6.1

* Removed the 'work in progress' text from the readme file.
* Added a version constraint to the Installation part of the readme file.

## 0.6.0

* Renamed Database::makeUniquePrimaryString() to makeUniqueString().
* Added the 'embark:move-models' command.
* Added the 'models_namespace' setting in config.
* Updated the readme file.

## 0.5.0

* Added the 'embark:webpack' command, which overwrites webpack.mix.js, using the custom public path, with some extras.
* Updated the readme file.
* Fixed: base_path() didn't work in the custom Application class.

## 0.4.0

* Improved the readme file.
* Added the 'embark:restructure' command, which changes the directory structure.

## 0.3.0

* Not using env() in config file anymore.
* Prefixed the publish tags, for easier publishing without conflicts.
* Added publishable .scss files.
* Simplified the migration creation.
* Added the 'update' migration stub.

## 0.2.0

* Added a PHP >= 7.1.3 requirement, matching Laravel 5.6.
* Added custom migration stubs: 'blank' and 'create'. Use the 'embark:migration' command for these, which has the same functionality as the default 'make:migration', only the stubs are different.

## 0.1.0

Initial release.
