<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Machine;
use App\Models\Transaction;
use App\Models\Warehouse;
use App\Models\MachineCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $totalWarehouses = Warehouse::count();
        $totalMaterials = Material::count();
        $totalTransactions = Transaction::count();

        $recentTransactions = Transaction::with(['material' => fn($q) => $q->withTrashed(), 
                                                'warehouse' => fn($q) => $q->withTrashed(), 
                                                'user'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        $lowStockMaterials = DB::table('transactions')
            ->join('materials', 'transactions.m_id', '=', 'materials.id')
            ->join('warehouses', 'transactions.wh_id', '=', 'warehouses.id')
            ->select(
                'materials.m_name',
                'materials.m_limit',
                'warehouses.wh_name',
                DB::raw('SUM(CASE WHEN transactions.type = 1 THEN transactions.qty ELSE 0 END) - SUM(CASE WHEN transactions.type = 0 THEN transactions.qty ELSE 0 END) as current_stock')
            )
            ->whereNull('transactions.deleted_at')
            ->whereNull('materials.deleted_at')
            ->whereNull('warehouses.deleted_at')
            ->where('materials.m_limit', '>', 0)
            ->groupBy('materials.id', 'materials.m_name', 'materials.m_limit', 'warehouses.id', 'warehouses.wh_name')
            ->havingRaw('current_stock < materials.m_limit AND current_stock >= 0')
            ->orderBy('current_stock', 'asc')
            ->take(5)
            ->get();

        $totalLowStock = $lowStockMaterials->count();
        $machineStatus = Machine::whereNull('deleted_at')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $monthlyTransactions = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN type = 1 THEN qty ELSE 0 END) as stock_in'),
                DB::raw('SUM(CASE WHEN type = 0 THEN qty ELSE 0 END) as stock_out')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->whereNull('deleted_at')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        if ($monthlyTransactions->isEmpty()) {
            $monthlyTransactions = collect();
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthlyTransactions->push((object)[
                    'month' => $date->month,
                    'year' => $date->year,
                    'stock_in' => 0,
                    'stock_out' => 0
                ]);
            }
        }

        $topMaterials = DB::table('transactions')
            ->join('materials', 'transactions.m_id', '=', 'materials.id')
            ->select(
                'materials.m_name',
                DB::raw('SUM(transactions.qty) as total_qty'),
                DB::raw('COUNT(transactions.id) as transaction_count')
            )
            ->where('transactions.created_at', '>=', Carbon::now()->subDays(30))
            ->whereNull('transactions.deleted_at')
            ->whereNull('materials.deleted_at')
            ->groupBy('materials.id', 'materials.m_name')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        $warehouseStocks = DB::table('transactions')
            ->join('warehouses', 'transactions.wh_id', '=', 'warehouses.id')
            ->select(
                'warehouses.wh_name',
                'warehouses.wh_type',
                DB::raw('SUM(CASE WHEN transactions.type = 1 THEN transactions.qty ELSE 0 END) as total_in'),
                DB::raw('SUM(CASE WHEN transactions.type = 0 THEN transactions.qty ELSE 0 END) as total_out'),
                DB::raw('SUM(CASE WHEN transactions.type = 1 THEN transactions.qty ELSE 0 END) - SUM(CASE WHEN transactions.type = 0 THEN transactions.qty ELSE 0 END) as current_stock')
            )
            ->whereNull('transactions.deleted_at')
            ->whereNull('warehouses.deleted_at')
            ->groupBy('warehouses.id', 'warehouses.wh_name', 'warehouses.wh_type')
            ->orderBy('current_stock', 'desc')
            ->get();

        $machinePerformance = DB::table('machine_counters')
            ->join('machines', 'machine_counters.machine_id', '=', 'machines.id')
            ->select(
                'machines.name',
                'machines.code',
                'machines.status',
                DB::raw('MAX(machine_counters.counter) as latest_counter'),
                DB::raw('MAX(machine_counters.recorded_at) as last_recorded')
            )
            ->whereNull('machine_counters.deleted_at')
            ->whereNull('machines.deleted_at')
            ->groupBy('machines.id', 'machines.name', 'machines.code', 'machines.status')
            ->orderBy('last_recorded', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalWarehouses',
            'totalMaterials', 
            'totalLowStock',
            'totalTransactions',
            'recentTransactions',
            'lowStockMaterials',
            'machineStatus',
            'monthlyTransactions',
            'topMaterials',
            'warehouseStocks',
            'machinePerformance'
        ));
    }
}