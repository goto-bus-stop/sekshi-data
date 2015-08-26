<?php

namespace App;

use Jenssegers\Mongodb\Model as MongoModel;

class Model extends MongoModel
{
    public function getRawIdAttribute()
    {
        return $this->attributes['_id'];
    }

    public static function pipeline()
    {
        $pipeline = func_get_args();
        return static::raw(function ($collection) use ($pipeline) {
            return collect($collection->aggregate($pipeline)['result']);
        });
    }
}
