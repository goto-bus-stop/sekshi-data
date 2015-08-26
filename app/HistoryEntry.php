<?php

namespace App;

class HistoryEntry extends Model
{
    protected $collection = 'historyentries';

    /**
     * Carbonifiable dates.
     *
     * @var array
     */
    protected $dates = ['time'];

    public function mediaM()
    {
        return $this->belongsTo('App\Media', 'media');
    }

    public function djM()
    {
        return $this->belongsTo('App\User', 'dj');
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
