<?php

namespace App;

use Jenssegers\Mongodb\Model;

class HistoryEntry extends Model
{
    protected $collection = 'historyentries';

    /**
     * Carbonifiable dates.
     *
     * @var array
     */
    protected $dates = ['time'];

    /**
     * Fix some key names to be more Eloquent-friendly.
     */
    public function setRawAttributes(array $attributes, $sync = false)
    {
        if (isset($attributes['media'])) {
            $attributes['media_id'] = $attributes['media'];
            unset($attributes['media']);
        }
        if (isset($attributes['dj'])) {
            $attributes['dj_id'] = $attributes['dj'];
            unset($attributes['dj']);
        }
        return parent::setRawAttributes($attributes, $sync);
    }

    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    public function dj()
    {
        return $this->belongsTo('App\User', 'dj_id');
    }

    public function score()
    {
        return $this->embedsOne('App\HistoryEntryScore');
    }

    public function skip()
    {
        return $this->embedsOne('App\HistoryEntryScore');
    }
}
