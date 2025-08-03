<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $machines = Machine::query()
            ->withTrashed()
            ->when($search, function ($query, $search) {
                $query->where('code',        'like', "%{$search}%")
                      ->orWhere('name',      'like', "%{$search}%")
                      ->orWhere('type',      'like', "%{$search}%")
                      ->orWhere('location',  'like', "%{$search}%")
                      ->orWhere('status',    'like', "%{$search}%")
                      ->orWhereHas('warehouse', fn($q2) =>
                       $q2->where('wh_name','like',"%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $warehouses = Warehouse::orderBy('wh_name')->get();

        return view('machines.index', compact('machines', 'warehouses', 'search'));
    }

    public function create()
    {
        return view('machines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wh_id'    => 'required|exists:warehouses,id',
            'code'     => 'required|string|max:50|unique:machines,code',
            'name'     => 'required|string|max:100',
            'type'     => 'required|string|max:50',
            'location' => 'nullable|string|max:100',
            'status'   => 'required|in:active,maintenance,broken',
        ]);

        Machine::create($request->only(['wh_id','code','name','type','location','status']));

        return redirect()->route('machines.index')
                         ->with('success', 'Machine berhasil ditambahkan.');
    }

    public function edit(Machine $machine)
    {
        return view('machines.edit', compact('machine'));
    }

    public function update(Request $request, Machine $machine)
    {
        $request->validate([
            'wh_id'    => 'required|exists:warehouses,id',
            'code'     => 'required|string|max:50|unique:machines,code,'.$machine->id,
            'name'     => 'required|string|max:100',
            'type'     => 'required|string|max:50',
            'location' => 'nullable|string|max:100',
            'status'   => 'required|in:active,maintenance,broken',
        ]);

        $machine->update($request->only(['wh_id','code','name','type','location','status']));

        return redirect()->route('machines.index')
                         ->with('success', 'Machine berhasil diperbarui.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route('machines.index')
                         ->with('success', 'Machine berhasil dihapus.');
    }

    public function restore($id)
    {
        Machine::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('machines.index')
                         ->with('success', 'Machine berhasil dipulihkan.');
    }
}
