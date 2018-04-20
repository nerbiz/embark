<?php

namespace Nerbiz\Embark\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as BaseMigrationCreator;

class MigrationCreator extends BaseMigrationCreator
{
    /**
     * {@inheritdoc}
     */
    protected function getStub($table, $create)
    {
        // Use a custom 'blank' stub
        if ($table === null) {
            return $this->files->get(dirname(__FILE__, 3) . '/stubs/migration-blank.stub');
        }

        // Use a custom 'create' stub
        else if ($table !== null && $create) {
            return $this->files->get(dirname(__FILE__, 3) . '/stubs/migration-create.stub');
        }

        // Otherwise fall back to the default stub
        else {
            return parent::getStub($table, $create);
        }
    }
}
