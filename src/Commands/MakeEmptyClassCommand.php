<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Nerbiz\Embark\EmbarkServiceProvider;

class MakeEmptyClassCommand extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'embark:empty-class';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create an empty class with only a constructor';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Empty class';

    /**
     * {@inheritdoc}
     */
    protected function getStub() {
        return EmbarkServiceProvider::getStubPath('empty-class.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . config('embark.generating_namespace');
    }

    /**
     * {@inheritdoc}
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the empty class.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [];
    }
}
