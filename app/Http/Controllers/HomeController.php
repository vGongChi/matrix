<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\CtaSection;
use App\Models\Case_;
use App\Models\HeroFeature;
use App\Models\HeroSection;
use App\Models\Process;
use App\Models\Service;
use App\Models\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        $hero = HeroSection::orderBy('id')->first();
        $heroFeatures = HeroFeature::orderBy('sort')->get();
        $services = Service::orderBy('sort')->get();
        $cases = Case_::with('tags')->orderBy('created_at', 'desc')->take(3)->get();
        $advantages = Advantage::orderBy('sort')->get();
        $processes = Process::orderBy('step')->get();
        $cta = CtaSection::orderBy('id')->first();

        return view('home', compact(
            'settings',
            'hero',
            'heroFeatures',
            'services',
            'cases',
            'advantages',
            'processes',
            'cta'
        ));
    }
}
