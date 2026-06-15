<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CtaSection;

class CtaSectionController extends Controller
{
    public function index()
    {
        return response()->json(CtaSection::all());
    }
}
