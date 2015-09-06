<?php

namespace App;

use Jenssegers\Mongodb\Model as MongoModel;
use App\Relations\BelongsTo;

class Model extends MongoModel
{
    public function getRawIdAttribute()
    {
        return $this->attributes['_id'];
    }

    /**
     * Define an inverse one-to-one or many relationship.
     * This is a simplified version of the Jenssegers\Mongodb version, that does
     * not support relations to non-mongo models, but does support relations on
     * keys of types that don't map to PHP primitives.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $otherKey
     * @param  string  $relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsTo($related, $foreignKey = null, $otherKey = null, $relation = null)
    {
        if (is_null($foreignKey)) {
            throw new \InvalidArgumentException('No foreign key provided');
        }

        // If no relation name was given, we will use this debug backtrace to extract
        // the calling method's name and use that as the relationship name as most
        // of the time this will be what we desire to use for the relatinoships.
        if (is_null($relation)) {
            list (, $caller) = debug_backtrace(false);

            $relation = $caller['function'];
        }

        $instance = new $related;

        // Once we have the foreign key names, we'll just create a new Eloquent query
        // for the related models and returns the relationship instance which will
        // actually be responsible for retrieving and hydrating every relations.
        $query = $instance->newQuery();

        $otherKey = $otherKey ?: $instance->getKeyName();

        return new BelongsTo($query, $this, $foreignKey, $otherKey, $relation);
    }

    public static function pipeline()
    {
        $pipeline = func_get_args();
        return static::raw(function ($collection) use ($pipeline) {
            return collect($collection->aggregate($pipeline)['result']);
        });
    }
}
