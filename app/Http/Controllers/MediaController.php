<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Media;
use App\HistoryEntry;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $cid
     * @return Response
     */
    public function show($cid)
    {
        $media = Media::where('cid', '=', $cid)->first();
        $mostPlayed = HistoryEntry::pipeline(
            [ '$match' => [ 'media' => $media->raw_id ] ],
            [ '$group' => [ '_id' => '$dj', 'count' => [ '$sum' => 1 ] ] ],
            [ '$sort' => [ 'count' => -1 ] ],
            [ '$limit' => 1 ]
        )[0];
        $lover = isset($mostPlayed['_id']) ? User::find($mostPlayed['_id']) : null;
        return view('media.show', [
            'media' => $media,
            'history' => $media->history()->paginate(25),
            'lover' => $lover,
            'loverCount' => $lover ? $mostPlayed['count'] : 0
        ]);
    }
}
