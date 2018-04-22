# Release notes

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
