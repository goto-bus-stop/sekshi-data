<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Achievement;
use App\AchievementUnlock;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $achievements = Achievement::with('unlockCount')->get();
        return view('achievements.index', [
            'achievements' => $achievements->sortBy('unlockCount')->reverse()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show($id)
    {
        $achievement = Achievement::find($id);
        $unlocks = $achievement->unlocks()->orderBy('time', 'desc')->paginate(50);
        $unlocks->load('userM');
        return view('achievements.show', [
            'achievement' => $achievement,
            'unlocks' => $unlocks
        ]);
    }
}
