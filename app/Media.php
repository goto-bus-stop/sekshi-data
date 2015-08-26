<?php

namespace App;

use Jenssegers\Mongodb\Model;

class Media extends Model
{
    protected $collection = 'media';

    public function getFullTitleAttribute()
    {
        return $this->author . ' - ' . $this->title;
    }
}
