<?php

namespace App\Http\Controllers\Api;

use App\Models\Material;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::active()->ordered();
        
        if ($request->has('type')) {
            $query->byType($request->get('type'));
        }
        
        return response()->json(
            $query->paginate($request->get('per_page', 12))
        );
    }

    public function show($id)
    {
        $material = Material::active()->findOrFail($id);
        return response()->json($material);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video,text,code',
            'description' => 'nullable|string',
            'thumbnail' => 'required|string|url',
            'image_url' => 'nullable|array',
            'image_url.*' => 'string|url',
            'video_url' => 'nullable|string|url',
            'text_content' => 'nullable|string',
            'code_content' => 'nullable|string',
            'code_language' => 'nullable|string|max:50',
            'code_repo_url' => 'nullable|string|url',
            'sort' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        return response()->json(Material::create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string|max:255',
            'type' => 'in:image,video,text,code',
            'description' => 'nullable|string',
            'thumbnail' => 'string|url',
            'image_url' => 'nullable|array',
            'image_url.*' => 'string|url',
            'video_url' => 'nullable|string|url',
            'text_content' => 'nullable|string',
            'code_content' => 'nullable|string',
            'code_language' => 'nullable|string|max:50',
            'code_repo_url' => 'nullable|string|url',
            'sort' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $material->update($validated);
        return response()->json($material);
    }

    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
