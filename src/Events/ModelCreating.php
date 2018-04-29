<?php

namespace Nerbiz\Embark\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Nerbiz\Embark\Database;

class ModelCreating
{
    use Dispatchable, SerializesModels;

    /**
     * Perform actions when a model instance is being created
     * @param Model $model The model that is being created
     * @return void
     */
    public function __construct(Model $model)
    {
        // Create and set the primary key string
        $model->id = with(new Database)->makeUniqueString(get_class($model));
    }
}
