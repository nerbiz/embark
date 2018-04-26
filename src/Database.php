<?php

namespace Nerbiz\Embark;

class Database
{
    /**
     * The varchar length of a string column
     * @var string
     */
    protected $varcharLength;

    public function __construct()
    {
        $this->varcharLength = config('embark.string_pk_length');
    }

    /**
     * Generate a unique random string for use as a primary key
     * While intended for primary keys, this can be used for any column
     * @param  string $modelClass Fully qualified classname of an Eloquent model
     * @param  string $column     The column to generate the string for
     * @return string
     */
    public function makeUniqueString($modelClass, $column = 'id')
    {
        // Generate a string, and re-generate it, if it already exists
        do {
            $generated = str_random($this->varcharLength);
        } while ($modelClass::where($column, $generated)->count() > 0);

        return $generated;
    }

    /**
     * Validate a string, according to the generated format of this class
     * @param  string $string
     * @return boolean
     */
    public function validateString($string)
    {
        return (preg_match('~^[a-z\d]{' . $this->varcharLength . '}$~i', $key) === 1);
    }
}
