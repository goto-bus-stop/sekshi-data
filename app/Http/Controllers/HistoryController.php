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
     * @return Response
     */
    public function index()
    {
        return view('history.show', [
            'entries' => HistoryEntry::orderBy('time', 'desc')
                                     ->whereNotNull('media')
                                     ->paginate(50)
        ]);
    }
}
