@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" style="min-height: calc(100vh - 120px);">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Belanja Bahan</h5>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createTransactionModal"
                    >
                        + Tambah Transaksi
                    </button>
                </div>
                <div class="card-body d-flex flex-column">
                    <form method="GET" action="{{ route('purchasing.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama bahan..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('purchasing.index') }}" class="btn btn-outline-danger">Reset</a>
                            @endif
                        </div>
                    </form>
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan</th>
                                    <th>Gudang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $index => $trx)
                                    <tr>
                                        <td>{{ $transactions->firstItem() + $index }}</td>
                                        <td>{{ $trx->material->m_name ?? '-' }}</td>
                                        <td>{{ $trx->warehouse->branch_name ?? '-' }}</td>
                                        <td>{{ $trx->qty }}</td>
                                        <td>Rp {{ number_format($trx->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($trx->qty * $trx->price, 0, ',', '.') }}</td>
                                        <td>{{ $trx->date?->format('d-m-Y') ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('purchasing.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="bx bx-trash me-1"></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($transactions->total() > 0)
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-column flex-md-row">
                                <div>
                                    <small class="text-muted">
                                        Menampilkan {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} dari {{ $transactions->total() }} entri
                                    </small>
                                </div>
                                <div>
                                    {{ $transactions->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="createTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('purchasing.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="m_id" class="form-label">Nama Bahan</label>
                        <select name="m_id" id="m_id" class="form-select" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->m_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wh_id" class="form-label">Gudang</label>
                        <select name="wh_id" id="wh_id" class="form-select" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="number" name="qty" id="qty" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Satuan</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Notiflix.Notify.failure("{{ $errors->first() }}");
    });
</script>
@endif

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Notiflix.Notify.success("{{ session('success') }}");
    });
</script>
@endif
@endsection
