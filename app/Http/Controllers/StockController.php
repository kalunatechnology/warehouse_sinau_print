<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Warehouse;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $warehouseCount = Warehouse::whereNull('deleted_at')->count();
        $materialCount = Material::whereNull('deleted_at')->count();
        $transactionCount = Transaction::count();

        $stocksQuery = DB::table('transactions')
            ->join('warehouses', 'transactions.wh_id', '=', 'warehouses.id')
            ->join('materials', 'transactions.m_id', '=', 'materials.id')
            ->select(
                'warehouses.id as warehouse_id',
                'warehouses.wh_type',
                'warehouses.wh_name',
                'materials.id as material_id',
                'materials.m_name',
                'materials.waste',
                DB::raw('SUM(CASE WHEN transactions.type = 1 THEN transactions.qty ELSE 0 END) as stock_in'),
                DB::raw('SUM(CASE WHEN transactions.type = 0 THEN transactions.qty ELSE 0 END) as stock_out'),
                DB::raw('SUM(CASE WHEN transactions.type = 1 THEN transactions.qty ELSE 0 END) - SUM(CASE WHEN transactions.type = 0 THEN transactions.qty ELSE 0 END) as stock')
            )
            ->whereNull('warehouses.deleted_at')
            ->whereNull('materials.deleted_at')
            ->groupBy(
                'warehouses.id',
                'warehouses.wh_type', 
                'warehouses.wh_name',
                'materials.id',
                'materials.m_name',
                'materials.waste'
            );

        if ($search) {
            $stocksQuery->where(function($query) use ($search) {
                $query->where('warehouses.wh_name', 'like', "%{$search}%")
                      ->orWhere('warehouses.wh_type', 'like', "%{$search}%")
                      ->orWhere('materials.m_name', 'like', "%{$search}%");
            });
        }
        
        $stocks = $stocksQuery
            ->orderBy('warehouses.wh_name')
            ->orderBy('materials.m_name')
            ->paginate(10);

        return view('stocks.index', compact('stocks', 'search'));
    }
}