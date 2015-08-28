<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Media;
use App\HistoryEntry;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return Response
     */
    public function show($slug)
    {
        $user = User::where('slug', '=', $slug)->first();
        if (!$user && is_numeric($slug)) {
            $user = User::find((int) $slug);
        }

        $mostPlayed = HistoryEntry::pipeline(
            [ '$match' => [ 'dj' => $user->raw_id ] ],
            [ '$group' => [ '_id' => '$media', 'count' => [ '$sum' => 1 ] ] ],
            [ '$sort' => [ 'count' => -1 ] ],
            [ '$limit' => 1 ]
        )[0];
        $favorite = isset($mostPlayed['_id']) ? Media::find($mostPlayed['_id']) : null;

        $karma = $user->karma()->count();

        return view('user.show', [
            'user' => $user,
            'history' => $user->history()->paginate(25),
            'karma' => $karma,
            'favorite' => $favorite,
            'favoriteCount' => $favorite ? $mostPlayed['count'] : 0
        ]);
    }
}
