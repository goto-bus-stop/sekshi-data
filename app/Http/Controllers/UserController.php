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
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pageSize = 50;
        $users = User::whereNotNull('username');

        $search = $request->input('q');
        if ($search) {
            $users = User::where('username', 'regexp', '/' . preg_quote($search, '/') . '/i');
        }

        $paginate = null;
        switch ($request->input('sort')) {
        default:
            $users->orderBy('_id', 'asc');
            $paginate = $users->paginate($pageSize);
            break;
        }
        $paginate->setPath(action('UserController@index'));
        $paginate->appends($request->except('page'));
        return view('user.index', [
            'users' => $paginate
        ]);
    }

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
        );
        $favorite = count($mostPlayed) > 0 ? Media::find($mostPlayed[0]['_id']) : null;

        $karma = $user->karma()->sum('amount');
        $achievements = $user->achievements()
            ->select('time', 'achievement')
            ->with('achievementM')
            ->orderBy('time', 'desc')
            ->get();

        return view('user.show', [
            'user' => $user,
            'history' => $user->history()->paginate(25),
            'karma' => $karma,
            'achievements' => $achievements,
            'favorite' => $favorite,
            'favoriteCount' => $favorite ? $mostPlayed[0]['count'] : 0
        ]);
    }
}
