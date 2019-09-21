# Release notes

## 0.16.3
#### 2019-09-21

* Replaced the removed str_plural() with Str::plural().

## 0.16.2
#### 2019-04-21

* Fixed: home stub wasn't extending the proper layout.

## 0.16.1
#### 2019-04-21

* Added MySQL date/time formats to the database Helper.
* Fixed: wrong stubs path for migrations.

## 0.16.0
#### 2019-04-07

* Added the 'embark:run-task' command, to immediately run a scheduled task.
* Converted command routes to Command classes.

## 0.15.0
#### 2019-03-10

* Added the Transaction class for easy database transactions.
* The varchar length fix is now done with an explicit (static) method, instead of automatically in the service provider.
* Added the 'embark:clear-logs' command, to delete *.log files in storage/logs.

## 0.14.0
#### 2018-07-13

* Added custom model stubs.
* Custom stubs are now publishable (with the 'embark-stubs' tag), for easy stubs editing.

## 0.13.0
#### 2018-07-12

* Breaking change: removed MigrationHelper, now using a custom Blueprint for migrations.

## 0.12.0
#### 2018-07-09

* Added the 'embark:model' command, works just like 'make:model', but it uses the custom models namespace.
* Added the CSRF token in a meta tag in head.blade.php (useful for JavaScript).

## 0.11.0
#### 2018-06-27

* Removed the .scss files, moving it to a frontend (NPM) package.

## 0.10.0
#### 2018-05-06

* Some basic views can now be published from the service provider.

## 0.9.0
#### 2018-05-06

* Added MigrationHelper::dropForeign() and MigrationHelper::dropForeignColumn().
* Improved the migration stub files.
* Renamed the 'move-models' command to 'models-namespace'.

## 0.8.0
#### 2018-05-03

* Improved Bootstrap spacer variables format.
* Removed all the primary/foreign keys as strings functionality, because it's bad for performance.

## 0.7.0
#### 2018-04-26

* Added Database::validateString(), for checking string column validity, according to the primary string column format.
* Added a fix for the 'max key length is 767 bytes' error (optional, defined in config), which occurs in some DB environments.

## 0.6.3
#### 2018-04-26

* Fixed: after creating a new Controllers namespace, the path to the webpack.mix.stub file was invalid.

## 0.6.2
#### 2018-04-26

* Changed the description line of this project.
* Improved a comment in the config file.

## 0.6.1
#### 2018-04-25

* Removed the 'work in progress' text from the readme file.
* Added a version constraint to the Installation part of the readme file.

## 0.6.0
#### 2018-04-25

* Renamed Database::makeUniquePrimaryString() to makeUniqueString().
* Added the 'embark:move-models' command.
* Added the 'models_namespace' setting in config.
* Updated the readme file.

## 0.5.0
#### 2018-04-22

* Added the 'embark:webpack' command, which overwrites webpack.mix.js, using the custom public path, with some extras.
* Updated the readme file.
* Fixed: base_path() didn't work in the custom Application class.

## 0.4.0
#### 2018-04-22

* Improved the readme file.
* Added the 'embark:restructure' command, which changes the directory structure.

## 0.3.0
#### 2018-04-20

* Not using env() in config file anymore.
* Prefixed the publish tags, for easier publishing without conflicts.
* Added publishable .scss files.
* Simplified the migration creation.
* Added the 'update' migration stub.

## 0.2.0
#### 2018-04-20

* Added a PHP >= 7.1.3 requirement, matching Laravel 5.6.
* Added custom migration stubs: 'blank' and 'create'. Use the 'embark:migration' command for these, which has the same functionality as the default 'make:migration', only the stubs are different.

## 0.1.0
#### 2018-04-20

Initial release.
