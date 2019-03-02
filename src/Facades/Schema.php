<?php

namespace Nerbiz\Embark\Facades;

use Illuminate\Support\Facades\Schema as BaseSchema;
use Illuminate\Database\Schema\Builder;
use Nerbiz\Embark\Schema\Blueprint;

class Schema extends BaseSchema
{
    /**
     * {@inheritdoc}
     */
    public static function connection($name)
    {
        return static::getCustomSchemaBuilder(parent::connection($name));
    }

    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return static::getCustomSchemaBuilder(parent::getFacadeAccessor());
    }

    /**
     * Get a builder with a custom blueprint
     * @param Builder $builder
     * @return \Illuminate\Database\Schema\Builder
     */
    protected static function getCustomSchemaBuilder(Builder $builder)
    {
        $builder->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });

        return $builder;
    }
}
