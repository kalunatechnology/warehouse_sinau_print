<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $warehouses = Warehouse::query()
            ->when($search, function ($query, $search) {
                $query->where('branch_name', 'like', "%{$search}%")
                    ->orWhere('wh_name', 'like', "%{$search}%")
                    ->orWhere('wh_type', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('warehouses.index', compact('warehouses', 'search'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'wh_type' => 'required|in:Gudang Barang,Gudang Jasa',
            'wh_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Warehouse::create($request->all());
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'wh_type' => 'required|in:Gudang Barang,Gudang Jasa',
            'wh_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil dihapus.');
    }
}
