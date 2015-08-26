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
}
