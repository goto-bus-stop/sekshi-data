<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/history', function () {
    return view('history.show', [
        'entries' => App\HistoryEntry::orderBy('time', 'desc')->paginate(50)
    ]);
});

Route::get('/media/{cid}', function ($cid) {
    $media = App\Media::where('cid', '=', $cid)->first();
    $mostPlayed = App\HistoryEntry::pipeline(
        [ '$match' => [ 'media' => $media->raw_id ] ],
        [ '$group' => [ '_id' => '$dj', 'count' => [ '$sum' => 1 ] ] ],
        [ '$sort' => [ 'count' => -1 ] ],
        [ '$limit' => 1 ]
    )[0];
    $lover = isset($mostPlayed['_id']) ? App\User::find($mostPlayed['_id']) : null;
    return view('media.show', [
        'media' => $media,
        'history' => $media->history()->paginate(25),
        'lover' => $lover,
        'loverCount' => $lover ? $mostPlayed['count'] : 0
    ]);
});

Route::get('/user/{slug}', function ($slug) {
    $user = App\User::where('slug', '=', $slug)->first();
    if (!$user && is_numeric($slug)) {
        $user = App\User::find((int) $slug);
    }

    $mostPlayed = App\HistoryEntry::pipeline(
        [ '$match' => [ 'dj' => $user->raw_id ] ],
        [ '$group' => [ '_id' => '$media', 'count' => [ '$sum' => 1 ] ] ],
        [ '$sort' => [ 'count' => -1 ] ],
        [ '$limit' => 1 ]
    )[0];
    $favorite = isset($mostPlayed['_id']) ? App\Media::find($mostPlayed['_id']) : null;

    $karma = $user->karma()->count();

    return view('user.show', [
        'user' => $user,
        'history' => $user->history()->paginate(25),
        'karma' => $karma,
        'favorite' => $favorite,
        'favoriteCount' => $favorite ? $mostPlayed['count'] : 0
    ]);
});
