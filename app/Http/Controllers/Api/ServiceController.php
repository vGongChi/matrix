<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::orderBy('sort')->get());
    }

    public function show($id)
    {
        return response()->json(Service::findOrFail($id));
    }
}
