<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;
use Illuminate\Support\Str;
use Nerbiz\Embark\EmbarkServiceProvider;

class ModelMakeCommand extends BaseModelMakeCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'embark:model';

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . config('embark.models_namespace');
    }

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return EmbarkServiceProvider::getStubsPath('models/pivot.model.stub');
        }

        return EmbarkServiceProvider::getStubsPath('models/model.stub');
    }
}
