<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json(
            Team::active()->ordered()->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'video_url' => 'nullable|string|url',
            'audio_url' => 'nullable|string|url',
            'sort' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        return response()->json(Team::create($validated), 201);
    }

    public function show($id)
    {
        $team = Team::findOrFail($id);
        return response()->json($team);
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'nickname' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'video_url' => 'nullable|string|url',
            'audio_url' => 'nullable|string|url',
            'sort' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $team->update($validated);
        return response()->json($team);
    }

    public function destroy($id)
    {
        Team::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
