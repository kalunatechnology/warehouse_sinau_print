@extends('layouts.app')

@section('style')
<style>
.dashboard-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.stat-card .avatar-initial {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

.table-responsive {
    border-radius: 8px;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e7eaf3;
}

.badge-status {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.low-stock-alert {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left: 4px solid #ffc107;
}

.stock-safe {
    background: linear-gradient(135deg, #d1ecf1 0%, #a8e6cf 100%);
    border-left: 4px solid #28a745;
}

.card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: rgba(0, 0, 0, 0.1);
}

.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.welcome-card .card-body {
    position: relative;
    z-index: 2;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.1;
    z-index: 1;
}

.status-active {
    color: #28a745;
}

.status-maintenance {
    color: #ffc107;
}

.status-broken {
    color: #dc3545;
}

.chart-legend {
    margin-top: 1rem;
}

@media (max-width: 768px) {
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .card-title {
        font-size: 1rem;
    }
}

@keyframes shimmer {
    0% {
        background-position: -468px 0;
    }
    100% {
        background-position: 468px 0;
    }
}

.loading-shimmer {
    animation: shimmer 1.5s ease-in-out infinite;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 1000px 100%;
}

.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <div class="avatar-initial bg-primary rounded">
                                <i class="bx bx-store"></i>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Gudang</span>
                    <h3 class="card-title mb-2">{{ number_format($totalWarehouses) }}</h3>
                    <small class="text-success fw-semibold">
                        <a href="{{ route('warehouses.index') }}" class="text-decoration-none">Lihat Detail</a>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <div class="avatar-initial bg-success rounded">
                                <i class="bx bx-package"></i>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Bahan</span>
                    <h3 class="card-title mb-2">{{ number_format($totalMaterials) }}</h3>
                    <small class="text-success fw-semibold">
                        <a href="{{ route('materials.index') }}" class="text-decoration-none">Lihat Detail</a>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <div class="avatar-initial bg-danger rounded">
                                <i class="bx bx-error-circle"></i>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Stok Rendah</span>
                    <h3 class="card-title mb-2">{{ number_format($totalLowStock) }}</h3>
                    <small class="text-danger fw-semibold">
                        <a href="{{ route('stocks.minimum') }}" class="text-decoration-none">Lihat Detail</a>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <div class="avatar-initial bg-info rounded">
                                <i class="bx bx-transfer"></i>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Transaksi</span>
                    <h3 class="card-title mb-2">{{ number_format($totalTransactions) }}</h3>
                    <small class="text-success fw-semibold">
                        <a href="{{ route('stocks.transaction') }}" class="text-decoration-none">Lihat Detail</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7 order-1 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Transaksi Bulanan</h5>
                        <small class="text-muted">6 Bulan Terakhir</small>
                    </div>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 280px;">
                        <canvas id="monthlyTransactionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Status Mesin</h5>
                        <small class="text-muted">Kondisi Saat Ini</small>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    @if($machineStatus->count() > 0)
                        <div style="position: relative; height: 250px; width: 250px;">
                            <canvas id="machineStatusChart"></canvas>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bx bx-cog bx-lg text-muted mb-2"></i>
                            <p class="text-muted">Belum ada data mesin</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transaksi Terbaru</h5>
                    <small class="text-muted">7 Hari Terakhir</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Bahan</th>
                                    <th>Gudang</th>
                                    <th>Qty</th>
                                    <th>Tipe</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $transaction->material->m_name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $transaction->warehouse->wh_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($transaction->qty) }}</td>
                                    <td>
                                        @if($transaction->type == 1)
                                            <span class="badge bg-label-success">Masuk</span>
                                        @else
                                            <span class="badge bg-label-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Stok Rendah</h5>
                    <small class="text-muted">Perlu Restok</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Bahan</th>
                                    <th>Gudang</th>
                                    <th>Stok</th>
                                    <th>Minimal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockMaterials as $item)
                                <tr>
                                    <td>{{ $item->m_name }}</td>
                                    <td>{{ $item->wh_name }}</td>
                                    <td>
                                        <span class="badge bg-label-danger">{{ number_format($item->current_stock) }}</span>
                                    </td>
                                    <td>{{ number_format($item->m_limit) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-success">Semua stok aman!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Ringkasan Gudang</h5>
                    <small class="text-muted">Stok Per Gudang</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Gudang</th>
                                    <th>Tipe</th>
                                    <th>Total Masuk</th>
                                    <th>Total Keluar</th>
                                    <th>Stok Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouseStocks as $warehouse)
                                <tr>
                                    <td>{{ $warehouse->wh_name }}</td>
                                    <td>
                                        <span class="badge bg-label-{{ $warehouse->wh_type == 'Gudang Barang' ? 'primary' : 'info' }}">
                                            {{ $warehouse->wh_type }}
                                        </span>
                                    </td>
                                    <td class="text-success">{{ number_format($warehouse->total_in) }}</td>
                                    <td class="text-danger">{{ number_format($warehouse->total_out) }}</td>
                                    <td>
                                        <span class="fw-semibold {{ $warehouse->current_stock > 0 ? 'text-success' : 'text-warning' }}">
                                            {{ number_format($warehouse->current_stock) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyCtx = document.getElementById('monthlyTransactionChart');
    if (monthlyCtx) {
        const monthlyData = @json($monthlyTransactions);
        
        if (monthlyData && monthlyData.length > 0) {
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => {
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Des'];
                        return months[item.month - 1] + ' ' + item.year;
                    }),
                    datasets: [{
                        label: 'Stok Masuk',
                        data: monthlyData.map(item => item.stock_in || 0),
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        tension: 0.4,
                        fill: false
                    }, {
                        label: 'Stok Keluar',
                        data: monthlyData.map(item => item.stock_out || 0),
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        tension: 0.4,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Jumlah'
                            },
                            beginAtZero: true
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        } else {
            monthlyCtx.parentElement.innerHTML = '<div class="text-center p-4"><i class="bx bx-chart bx-lg text-muted mb-2"></i><p class="text-muted">Belum ada data transaksi</p></div>';
        }
    }

    const statusCtx = document.getElementById('machineStatusChart');
    if (statusCtx) {
        const statusData = @json($machineStatus);
        
        if (statusData && statusData.length > 0) {
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusData.map(item => {
                        const statusLabels = {
                            'active': 'Aktif',
                            'maintenance': 'Maintenance',
                            'broken': 'Rusak'
                        };
                        return statusLabels[item.status] || item.status;
                    }),
                    datasets: [{
                        data: statusData.map(item => item.count),
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(220, 53, 69, 0.8)'
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(255, 193, 7, 1)',
                            'rgba(220, 53, 69, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + ' mesin';
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }
    }
});
</script>
@endsection