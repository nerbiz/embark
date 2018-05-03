<?php

namespace Nerbiz\Embark\Migrations;

use Illuminate\Database\Schema\Blueprint;

class MigrationHelper
{
    /**
     * Shorter way of adding a foreign key
     * Assumes the format that 'category_id' references 'id' on 'categories'
     * @param  Blueprint   $table        The table to add the foreign key to
     * @param  string      $foreignKey   The foreign key column of the table
     * @param  string|null $foreignTable An explicit foreign table, instead of deriving one
     * @param  string|null $onUpdate     The ON UPDATE action
     * @param  string|null $onDelete     The ON DELETE action
     * @return void
     */
    public function foreign(
        Blueprint $table,
        $foreignKey,
        $foreignTable = null,
        $onUpdate = null,
        $onDelete = null
    ) {
        // Derive the foreign table name, if no explicit one is given
        if ($foreignTable === null) {
            // Convert something like 'category_id' to 'categories'
            $foreignTable = str_plural(preg_replace('~_id$~', '', $foreignKey));
        }

        // Get the 'on update/delete' actions from settings, if null
        if ($onUpdate === null) {
            $onUpdate = config('embark.default_on_update');
        }

        if ($onDelete === null) {
            $onDelete = config('embark.default_on_delete');
        }

        // Set the foreign key
        $table->foreign($foreignKey)
            ->references('id')
            ->on($foreignTable)
            ->onUpdate($onUpdate)
            ->onDelete($onDelete);
    }
}
