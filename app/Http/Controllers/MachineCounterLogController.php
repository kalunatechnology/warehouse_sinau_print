<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MachineCounterLog;
use App\Models\User;
use Illuminate\Http\Request;

class MachineCounterLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $logs = MachineCounterLog::with(['machine','user'])
            ->withTrashed()
            ->when($search, function($q,$s){
                $q->whereHas('machine', fn($q2)=>
                        $q2->where('code','like',"%{$s}%")
                           ->orWhere('name','like',"%{$s}%")
                    )
                  ->orWhere('description','like',"%{$s}%")
                  ->orWhere('counter_before', $s)
                  ->orWhere('counter_after', $s);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $machines = Machine::orderBy('code')->get();
        $users    = User::orderBy('name')->get();

        return view('machine_counter_logs.index', compact('logs','machines','users','search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'machine_id'     => 'required|exists:machines,id',
            'counter_before' => 'required|min:0',
            'counter_after'  => 'required|min:0',
            'description'    => 'nullable|string|max:255',
        ]);

        MachineCounterLog::create([
            'machine_id'     => $request->machine_id,
            'counter_before' => $request->counter_before,
            'counter_after'  => $request->counter_after,
            'changed_by'     => auth()->id(),
            'description'    => $request->description,
        ]);

        return redirect()->route('machine-counter-logs.index')
                         ->with('success','Riwayat counter berhasil ditambahkan.');
    }

    public function update(Request $request, MachineCounterLog $machineCounterLog)
    {
        $request->validate([
            'machine_id'     => 'required|exists:machines,id',
            'counter_before' => 'required|integer|min:0',
            'counter_after'  => 'required|integer|min:0',
            'description'    => 'nullable|string|max:255',
        ]);

        $machineCounterLog->update($request->only([
            'machine_id','counter_before','counter_after','description',
        ]));

        return redirect()->route('machine-counter-logs.index')
                         ->with('success','Riwayat counter berhasil diperbarui.');
    }

    public function destroy(MachineCounterLog $machineCounterLog)
    {
        $machineCounterLog->delete(); // soft delete
        return redirect()->route('machine-counter-logs.index')
                         ->with('success','Riwayat counter berhasil dihapus.');
    }

    public function restore($id)
    {
        MachineCounterLog::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('machine-counter-logs.index')
                         ->with('success','Riwayat counter berhasil dipulihkan.');
    }
}
