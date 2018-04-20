# Release notes

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
