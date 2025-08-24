<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Unit;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // $materials = Material::when($search, function ($query, $search) {
        //         return $query->where('m_name', 'like', "%{$search}%")
        //                      ->orWhere('m_type', 'like', "%{$search}%");
        //     })
        //     ->orderBy('id', 'desc')
        //     ->paginate(10);

        $materials = Material::latest()->get();

        $units = Unit::orderBy('u_name')->get();

        return view('materials.index', compact('materials', 'units', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'm_code' => 'required',
            'm_name' => 'required',
            'm_type' => 'nullable|string',
            'm_supplier' => 'nullable|string',
            'unit_id' => 'required|exists:units,id',
            'unit_detail' => 'nullable|string|max:255',
            'conversion' => 'nullable|numeric|min:0',
            'm_limit' => 'nullable|numeric|min:0',
            'waste' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['waste'] = $validated['waste'] ?? 0;

        Material::create($validated);

        return redirect()->route('materials.index')->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'm_code' => 'required',
            'm_name' => 'required',
            'm_type' => 'nullable|string',
            'm_supplier' => 'nullable|string',
            'unit_id' => 'required|exists:units,id',
            'unit_detail' => 'nullable|string|max:255',
            'conversion' => 'nullable|numeric|min:0',
            'm_limit' => 'nullable|numeric|min:0',
            'waste' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['waste'] = $validated['waste'] ?? 0;

        $material->update($validated);

        return redirect()->route('materials.index')->with('success', 'Bahan berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Bahan berhasil dihapus.');
    }

    public function copy(Material $material)
    {
        return view('materials.copy', compact('material'));
    }
}
