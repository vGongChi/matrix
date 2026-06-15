<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advantage;

class AdvantageController extends Controller
{
    public function index()
    {
        return response()->json(Advantage::orderBy('sort')->get());
    }

    public function show($id)
    {
        return response()->json(Advantage::findOrFail($id));
    }
}
