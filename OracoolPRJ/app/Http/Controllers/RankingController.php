<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * RankingController handles the ranking functionality.
 * It retrieves and displays user rankings based on points.
 */
class RankingController extends Controller
{
    /**
     * Display the ranking view with users ordered by points.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users=User::orderBy('points', 'desc')->get();

        return view('ranking', [
            'users' => $users,
        ]);
    }
}
