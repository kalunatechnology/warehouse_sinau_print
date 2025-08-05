<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Material;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with([
            // Tetap bisa akses material/warehouse yang sudah dihapus
            'material' => fn($q) => $q->withTrashed(),
            'warehouse' => fn($q) => $q->withTrashed()
        ]);

        if ($request->has('search') && $request->search !== '') {
            $query->whereHas('material', function ($q) use ($request) {
                $q->where('m_name', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->latest()->paginate(10);

        // Hanya ambil bahan & gudang yang aktif (belum di-soft-delete)
        $materials = Material::withoutTrashed()->get();
        $warehouses = Warehouse::withoutTrashed()->get();

        return view('purchasing.index', compact('transactions', 'materials', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'm_id' => 'required|exists:materials,id',
            'wh_id' => 'required|exists:warehouses,id',
            'qty' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'm_id' => $validated['m_id'],
            'wh_id' => $validated['wh_id'],
            'qty' => $validated['qty'],
            'price' => $validated['price'],
            'type' => 1,
            'date' => $validated['date'],
            'user_id' => Auth::id()
        ]);

        return redirect()->route('purchasing.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('purchasing.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

