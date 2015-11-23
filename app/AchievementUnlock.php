<?php

namespace App;

class AchievementUnlock extends Model
{
    protected $collection = 'achievementunlocks';

    /**
     * Carbonifyable dates.
     *
     * @var array
     */
    protected $dates = ['time'];

    public function achievementM()
    {
        return $this->belongsTo('App\Achievement', 'achievement');
    }

    public function giverM()
    {
        return $this->belongsTo('App\User', 'giver');
    }

    public function userM()
    {
        return $this->belongsTo('App\User', 'user');
    }
}
