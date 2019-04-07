<?php

namespace Nerbiz\Embark\Database;

use Illuminate\Support\Facades\Schema;

class Helper
{
    /**
     * The MySQL date format
     * @var string
     */
    const MYSQL_DATE_FORMAT = 'Y-m-d';

    /**
     * The MySQL datetime format
     * @var string
     */
    const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

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
