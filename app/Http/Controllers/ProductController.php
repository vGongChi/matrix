<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Settings;

class ProductController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        $products = Product::published()
            ->with('parent')
            ->orderByRaw("FIELD(level, 'light', 'standard', 'heavy')")
            ->orderBy('id')
            ->get();

        return view('product.index', compact('settings', 'products'));
    }
}
