<?php

namespace Nerbiz\Embark\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeEmptyClassCommand extends GeneratorCommand
{
    /**
     * {@inheritDoc}
     */
    protected $name = 'embark:empty-class';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Create an empty class with only a constructor';

    /**
     * {@inheritDoc}
     */
    protected $type = 'Empty class';

    /**
     * {@inheritDoc}
     */
    protected function replaceClass($stub, $name)
    {
        return parent::replaceClass($stub, $name);
    }

    /**
     * {@inheritDoc}
     */
    protected function getStub() {
        return dirname(__FILE__, 3) . '/stubs/empty-class.stub';
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . config('embark.generating_namespace');
    }

    /**
     * {@inheritDoc}
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the empty class.'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getOptions()
    {
        return [];
    }
}
