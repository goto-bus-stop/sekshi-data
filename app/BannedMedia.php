<?php

namespace App;

class BannedMedia extends Model
{
    protected $collection = 'bannedmedias';

    public function media()
    {
        return $this->belongsTo('App\Media', 'cid', 'cid');
    }

    public function bannedBy()
    {
        return $this->belongsTo('App\User', 'moderator');
    }
}
