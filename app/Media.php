<?php

namespace App;

class Media extends Model
{
    protected $collection = 'media';

    public function getFullTitleAttribute()
    {
        return $this->author . ' - ' . $this->title;
    }

    public function history()
    {
        return $this->hasMany('App\HistoryEntry', 'media', 'raw_id')
            ->orderBy('time', 'desc');
    }
}
