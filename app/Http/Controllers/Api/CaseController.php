<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Case_;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Case_::with('tags');

        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->query('tag_id'));
            });
        }

        if ($request->has('per_page')) {
            return response()->json($query->orderBy('created_at', 'desc')->paginate($request->query('per_page', 12)));
        }

        return response()->json($query->orderBy('created_at', 'desc')->get());
    }

    public function show($id)
    {
        return response()->json(Case_::with('tags')->findOrFail($id));
    }
}
