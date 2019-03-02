<?php

namespace Nerbiz\Embark\Database;

use Illuminate\Support\Facades\Schema;

class Helper
{
    /**
     * Apply the varchar length fix
     * @see https://laravel.com/docs/5.7/migrations#indexes
     * @return void
     */
    public static function stringLengthFix()
    {
        Schema::defaultStringLength(191);
    }
}
