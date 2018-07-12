<?php

namespace Nerbiz\Embark\Schema;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;

class Blueprint extends BaseBlueprint
{
    /**
     * Simplify foreign key creation, by using assumptions
     * Example: ['category_id', 'category_name'] references ['id', 'name'] on 'categories'
     */
    public function foreignKey($columns, $name = null)
    {
        $foreignTable = null;
        $foreignColumns = [];

        foreach ((array) $columns as $columnName) {
            preg_match('~(?<table>.+)_(?<column>.+)$~', $columnName, $matches);

            // Derive the table name once
            if ($foreignTable === null) {
                $foreignTable = str_plural($matches['table']);
            }

            $foreignColumns[] = $matches['column'];
        }

        return parent::foreign($columns, $name)
            ->references($foreignColumns)
            ->on($foreignTable)
            ->onUpdate(config('embark.default_on_update'))
            ->onDelete(config('embark.default_on_delete'));
    }
}
