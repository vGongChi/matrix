<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseTag;

class CaseTagController extends Controller
{
    public function index()
    {
        return response()->json(CaseTag::withCount('cases')->get());
    }

    public function show($id)
    {
        return response()->json(CaseTag::with('cases')->findOrFail($id));
    }
}
