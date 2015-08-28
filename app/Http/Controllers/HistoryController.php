<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HistoryEntry;
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
        $history = HistoryEntry::whereNotNull('media');
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
}
