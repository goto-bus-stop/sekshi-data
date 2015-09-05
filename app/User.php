<?php

namespace App;

use App\Relations\PlayCount;
use App\Relations\TotalKarma;

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

    public function totalKarma()
    {
        $instance = new Karma;
        return new TotalKarma($instance->newQuery(), $this, 'raw_id', 'target');
    }

    public function achievements()
    {
        return $this->hasMany('App\AchievementUnlock', 'user', 'raw_id');
    }

    public function playcount()
    {
        $instance = new HistoryEntry;
        return new PlayCount($instance->newQuery(), $this, 'raw_id', 'dj');
    }
}
