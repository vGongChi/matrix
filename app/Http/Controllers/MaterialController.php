<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Settings;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();
        $type = $request->get('type');
        
        $query = Material::active()->ordered();
        if ($type && in_array($type, array_keys(Material::getTypes()))) {
            $query->byType($type);
        }
        
        $materials = $query->paginate(12);
        $types = Material::getTypes();
        
        return view('material.index', compact('settings', 'materials', 'types', 'type'));
    }

    public function show($id)
    {
        $settings = Settings::first();
        $material = Material::active()->findOrFail($id);
        $relatedMaterials = Material::active()
            ->byType($material->type)
            ->where('id', '!=', $id)
            ->ordered()
            ->take(4)
            ->get();
        
        return view('material.show', compact('settings', 'material', 'relatedMaterials'));
    }
}
