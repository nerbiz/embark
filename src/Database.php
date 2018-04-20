<?php

namespace Nerbiz\Embark;

class Database
{
    /**
     * Generate a unique random string for use as a primary key
     * While intended for primary keys, this can be used for any column
     * @param  string $modelClass Fully qualified classname of an Eloquent model
     * @param  string $column     The primary key column to generate the string for
     * @return string
     */
    public function makeUniquePrimaryString($modelClass, $column = 'id')
    {
        // Generate a string, and re-generate it, if it already exists
        do {
            $generated = str_random(config('embark.string_pk_length'));
        } while ($modelClass::where($column, $generated)->count() > 0);

        return $generated;
    }
}
