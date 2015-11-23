<?php

namespace App;

use App\Relations\AchievementUnlockCount;

class Achievement extends Model
{
    protected $collection = 'achievements';

    public function unlocks()
    {
        return $this->hasMany('App\AchievementUnlock', 'achievement', 'raw_id');
    }

    public function unlockCount()
    {
        $instance = new AchievementUnlock;
        return new AchievementUnlockCount($instance->newQuery(), $this, 'raw_id', 'achievement');
    }
}
