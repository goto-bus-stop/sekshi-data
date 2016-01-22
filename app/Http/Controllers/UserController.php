<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Media;
use App\Karma;
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

        $users->with('playcount', 'totalKarma');

        $order = $request->input('order');

        $paginate = null;
        switch ($request->input('sort')) {
            case 'plays':
                $sort = ['plays' => -1, '_id' => 1];
                if ($order === 'asc') {
                    $sort = $this->reverse($sort);
                }
                $byPlays = collect(HistoryEntry::pipeline(
                    ['$match' => ['dj' => ['$ne' => null], 'media' => ['$ne' => null]]],
                    ['$group' => ['_id' => '$dj', 'plays' => ['$sum' => 1]]],
                    ['$sort' => $sort],
                    ['$skip' => $pageSize * ($request->input('page', 1) - 1)],
                    ['$limit' => $pageSize]
                ));
                $paginate = $this->getPaginator($users, $byPlays, $request->input('page', 1));
                break;
            case 'karma':
                $sort = ['karma' => -1, '_id' => 1];
                if ($order === 'asc') {
                    $sort = $this->reverse($sort);
                }
                $byKarma = collect(Karma::pipeline(
                    ['$group' => ['_id' => '$target', 'karma' => ['$sum' => '$amount']]],
                    ['$sort' => $sort],
                    ['$skip' => $pageSize * ($request->input('page', 1) - 1)],
                    ['$limit' => $pageSize]
                ));
                $paginate = $this->getPaginator($users, $byKarma, $request->input('page', 1));
                break;
            default:
                $users->orderBy('username', $order === 'desc' ? 'desc' : 'asc');
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
     * Reverse a MongoDB $sort option.
     *
     * @param  array  $sort
     * @return array
     */
    private function reverse($sort)
    {
        foreach ($sort as $key => $dir) {
            $sort[$key] = -$dir;
        }
        return $sort;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection  $users
     * @param  \Illuminate\Database\Eloquent\Collection  $sort
     * @param  integer  $current
     * @return \Illuminate\Pagination\Paginator
     */
    private function getPaginator($users, $sort, $current = 1)
    {
        $models = User::whereIn('_id', $sort->pluck('_id'))
            ->with('playcount', 'totalKarma')
            ->get();
        $results = $sort->map(function ($rec) use ($models) {
            return $models->whereLoose('id', $rec['_id'])->first();
        });
        return new LengthAwarePaginator(
            $results->all(),
            $users->count(),
            50,
            $current
        );
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
