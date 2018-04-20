<?php

namespace Nerbiz\Embark;

use Illuminate\Database\Migrations\MigrationCreator as BaseMigrationCreator;

class MigrationCreator
{
    /**
     * {@inheritdoc}
     */
    protected function getStub($table, $create)
    {
        // Use a custom 'blank' stub
        if ($table === null) {
            return dirname(__FILE__, 2) . '/stubs/migration-blank.stub';
        }

        // Use a custom 'create' stub
        else if ($table !== null && $create) {
            return dirname(__FILE__, 2) . '/stubs/migration-create.stub';
        }

        // Otherwise fall back to the default stub
        else {
            return parent::getStub($table, $create);
        }
    }
}
