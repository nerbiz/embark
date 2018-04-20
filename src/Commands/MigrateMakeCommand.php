<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand as BaseMigrateMakeCommand;
use Illuminate\Support\Composer;
use Nerbiz\Embark\Migrations\MigrationCreator;

class MigrateMakeCommand extends BaseMigrateMakeCommand
{
    /**
     * {@inheritdoc}
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        // Set a custom signature
        $this->signature = str_replace('make:', 'embark:', $this->signature);

        parent::__construct($creator, $composer);
    }
}
