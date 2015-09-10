<?php

namespace App;

use App\Relations\PlayCount;

class Media extends Model
{
    const YOUTUBE = 1;
    const SOUNDCLOUD = 2;

    protected $collection = 'media';

    public function getFullTitleAttribute()
    {
        return $this->author . ' - ' . $this->title;
    }

    public function getEmbeddableAttribute()
    {
        return $this->format === Media::YOUTUBE || $this->format === Media::SOUNDCLOUD;
    }

    public function getEmbedUrlAttribute()
    {
        if ($this->format === Media::YOUTUBE) {
            return 'https://www.youtube-nocookie.com/embed/' . $this->cid;
        } else if ($this->format === Media::SOUNDCLOUD) {
            $apiUrl = 'https://api.soundcloud.com/tracks/' . $this->cid;
            return 'https://w.soundcloud.com/player/?' . http_build_query([
                'url' => $apiUrl,
                'auto_play' => 'false',
                'hide_related' => 'false',
                'show_comments'=> 'true',
                'show_user' =>'true',
                'show_reposts' => 'false',
                'visual' => 'true'
            ]);
        }
    }

    public function history()
    {
        return $this->hasMany('App\HistoryEntry', 'media', 'raw_id')
            ->orderBy('time', 'desc');
    }

    public function playcount()
    {
        $instance = new HistoryEntry;
        return new PlayCount($instance->newQuery(), $this);
    }

    public function blacklisted()
    {
        return $this->hasOne('App\BannedMedia', 'cid', 'cid');
    }
}
