<?php

namespace Nerbiz\Embark;

use Illuminate\Database\Eloquent\Model;
use Nerbiz\Embark\Events\ModelCreating;

class PrimaryStringModel extends Model
{
    /**
     * Primary key is not an incrementing integer
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Model events and listeners
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => ModelCreating::class,
    ];
}
