<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;
use Illuminate\Support\Str;

class ModelMakeCommand extends BaseModelMakeCommand
{
    /**
     * {@inheritDoc}
     */
    protected $name = 'embark:model';

    /**
     * {@inheritDoc}
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('embark:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . config('embark.models_namespace');
    }

    /**
     * {@inheritDoc}
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return dirname(__FILE__, 3) . '/stubs/models/pivot.model.stub';
        }

        return dirname(__FILE__, 3) . '/stubs/models/model.stub';
    }
}
