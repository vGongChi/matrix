<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Settings;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        $teams = Team::active()->ordered()->get();
        return view('team.index', compact('settings', 'teams'));
    }

    public function show($id)
    {
        $settings = Settings::first();
        $team = Team::active()->findOrFail($id);
        $otherTeams = Team::active()->where('id', '!=', $id)->ordered()->take(3)->get();
        return view('team.show', compact('settings', 'team', 'otherTeams'));
    }
}
