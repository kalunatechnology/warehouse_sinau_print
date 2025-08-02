<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MachineCounter;
use Illuminate\Http\Request;

class MachineCounterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $counters = MachineCounter::with(['machine'])
            ->withTrashed()
            ->when($search, function ($q, $s) {
                $q->whereHas('machine', fn($q2) =>
                        $q2->where('code', 'like', "%{$s}%")
                            ->orWhere('name', 'like', "%{$s}%")
                    )
                  ->orWhere('counter', 'like', "%{$s}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // untuk dropdown create/edit
        $machines = Machine::orderBy('code')->get();

        return view('machine_counters.index', compact('counters', 'machines', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'machine_id'  => 'required|exists:machines,id',
            'counter'     => 'required|integer|min:0',
            'recorded_at' => 'required|date',
        ]);

        MachineCounter::create($request->only(['machine_id','counter','recorded_at']));

        return redirect()->route('machine-counters.index')
                         ->with('success', 'Counter mesin berhasil ditambahkan.');
    }

    public function update(Request $request, MachineCounter $machineCounter)
    {
        $request->validate([
            'machine_id'  => 'required|exists:machines,id',
            'counter'     => 'required|integer|min:0',
            'recorded_at' => 'required|date',
        ]);

        $machineCounter->update($request->only(['machine_id','counter','recorded_at']));

        return redirect()->route('machine-counters.index')
                         ->with('success', 'Counter mesin berhasil diperbarui.');
    }

    public function destroy(MachineCounter $machineCounter)
    {
        $machineCounter->delete();
        return redirect()->route('machine-counters.index')
                         ->with('success', 'Counter mesin berhasil dihapus.');
    }

    public function restore($id)
    {
        MachineCounter::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('machine-counters.index')
                         ->with('success', 'Counter mesin berhasil dipulihkan.');
    }
}
