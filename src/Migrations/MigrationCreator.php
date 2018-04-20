<?php

namespace Nerbiz\Embark\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as BaseMigrationCreator;

class MigrationCreator extends BaseMigrationCreator
{
    /**
     * {@inheritdoc}
     */
    public function stubPath()
    {
        return dirname(__FILE__, 3) . '/stubs/migrations';
    }
}
