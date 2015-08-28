<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Emote;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('emotes.show', [
            'emotes' => Emote::all()
        ]);
    }
}
