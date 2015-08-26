<?php

namespace App;

class User extends Model
{
    protected $collection = 'users';

    /**
     * Carbonifiable dates.
     *
     * @var array
     */
    protected $dates = ['joined', 'lastVisit'];

    public function history()
    {
        return $this->hasMany('App\HistoryEntry', 'dj', 'raw_id')
            ->whereNotNull('media')
            ->orderBy('time', 'desc');
    }

    public function karma()
    {
        return $this->hasMany('App\Karma', 'target', 'raw_id')
            ->orderBy('time', 'desc');
    }
}
