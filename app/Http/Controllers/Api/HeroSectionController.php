<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;

class HeroSectionController extends Controller
{
    public function index()
    {
        return response()->json(HeroSection::all());
    }
}
