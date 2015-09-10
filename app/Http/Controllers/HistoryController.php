<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\HistoryEntry;
use App\Media;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $history = HistoryEntry::whereNotNull('media')
            ->with('djM', 'mediaM', 'mediaM.blacklisted');
        $sort = $request->input('sort');
        switch ($sort) {
        case 'woots':
            $history->orderBy('score.positive', 'desc');
            break;
        case 'grabs':
            $history->orderBy('score.grabs', 'desc');
            break;
        case 'mehs':
            $history->orderBy('score.negative', 'desc');
            break;
        default:
            $history->orderBy('time', 'desc');
            break;
        }
        return view('history.index', [
            'entries' => $history->paginate(50)
                ->appends($sort ? ['sort' => $sort] : [])
        ]);
    }

    /**
     *
     */
    public function mostPlayed(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = 50;
        $byPlays = collect(HistoryEntry::pipeline(
            ['$match' => ['media' => ['$ne' => null]]],
            ['$group' => [
                '_id' => '$media',
                'plays' => ['$sum' => 1],
                'first' => ['$min' => '$time'] //['$first' => '$time']
            ]],
            ['$sort' => ['plays' => -1, '_id' => 1]],
            ['$skip' => $pageSize * ($page - 1)],
            ['$limit' => $pageSize]
        ));
        $models = Media::whereIn('_id', $byPlays->pluck('_id'))->get();
        $results = $byPlays->map(function ($rec) use ($models) {
            $media = $models->whereLoose('id', $rec['_id'])->first();
            $object = new \StdClass;
            $object->media = $media;
            $object->plays = $rec['plays'];
            $object->first_played = Carbon::createFromTimestamp($rec['first']->sec);
            return $object;
        });
        $total = HistoryEntry::pipeline(
            ['$group' => ['_id' => '$media']],
            ['$match' => ['_id' => ['$ne' => null]]],
            ['$group' => ['_id' => 1, 'count' => ['$sum' => 1]]]
        )[0];
        $mostPlayed = new LengthAwarePaginator(
            $results->all(),
            $total['count'],
            $pageSize,
            $request->input('page', 1)
        );
        $mostPlayed->setPath(action('HistoryController@mostPlayed'));
        $mostPlayed->appends($request->except('page'));
        return view('most_played.index', [
            'media' => $mostPlayed
        ]);
    }
}
