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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $media = Media::orderBy('author', 'asc')->orderBy('title', 'asc');
        $search = $request->input('q');
        if ($search) {
            $rx = '/' . preg_quote($search) . '/i';
            $media->where('author', 'regexp', $rx)
                  ->orWhere('title', 'regexp', $rx);
        }

        $media->with('playcount');
        $media->with('blacklisted');

        return view('media.index', [
            'list' => $media->paginate(50)
        ]);
    }

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
        $loverCount = $lover ? $mostPlayed['count'] : 0;

        $similar = $this->findSimilar($media)->get()->shuffle()->take(5);

        $history = $media->history()->paginate(25);

        return view('media.show', compact('media', 'similar', 'history', 'lover', 'loverCount'));
    }

    /**
     * Find different media items, possibly by the same artist.
     *
     * @param  App\Media $media
     * @return Illuminate\Support\Collection
     */
    public function findSimilar(Media $media)
    {
        $artist = trim($media->author);
        $matches = [];
        $searches = collect([$artist]);
        if (preg_match('/^(.*?)\((.*?)\)$/', $artist, $matches)) {
            list ($full, $eng, $han) = $matches;
            $searches[] = trim($eng);
            $searches[] = trim($han);
        }
        $parts = $searches->map(function ($search) { return preg_quote($search, '/'); })->toArray();
        $artistRegex = '/\b(' . implode('|', $parts) . ')\b/i';
        return Media::where('author', 'regexp', $artistRegex)
                    ->where('cid', '!=', $media->cid);
    }
}
