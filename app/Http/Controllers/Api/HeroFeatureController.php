<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroFeature;

class HeroFeatureController extends Controller
{
    public function index()
    {
        return response()->json(HeroFeature::orderBy('sort')->get());
    }
}
