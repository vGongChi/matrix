<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Process;

class ProcessController extends Controller
{
    public function index()
    {
        return response()->json(Process::orderBy('step')->get());
    }

    public function show($id)
    {
        return response()->json(Process::findOrFail($id));
    }
}
