<?php

use App\User;

if (!function_exists('user_url')) {
    function user_url(User $user)
    {
        if (!empty($user->slug)) {
            return url('user', $user->slug);
        }
        return url('user', $user->id);
    }
}
