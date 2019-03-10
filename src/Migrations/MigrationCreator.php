<?php

namespace Nerbiz\Embark\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as BaseMigrationCreator;
use Nerbiz\Embark\EmbarkServiceProvider;

class MigrationCreator extends BaseMigrationCreator
{
    /**
     * {@inheritdoc}
     */
    public function stubPath()
    {
        return EmbarkServiceProvider::getStubsPath('resources/migrations');
    }
}
