<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return response()->json(Settings::first() ?? []);
    }

    public function show($id)
    {
        return response()->json(Settings::findOrFail($id));
    }
}
