<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::latest();

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->has('per_page')) {
            return response()->json($query->paginate($request->query('per_page', 20)));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact' => 'required|string|max:255',
            'message' => 'nullable|string',
            'source' => 'nullable|string|max:100',
        ]);

        $lead = Lead::create($validated);

        return response()->json($lead, 201);
    }

    public function show($id)
    {
        return response()->json(Lead::findOrFail($id));
    }
}
