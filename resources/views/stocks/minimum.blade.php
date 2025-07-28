@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" style="min-height: calc(100vh - 120px);">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Stok Minimal</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <form method="GET" action="{{ route('stocks.minimum') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('stocks.minimum') }}" class="btn btn-outline-danger">Reset</a>
                            @endif
                        </div>
                    </form>
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gudang</th>
                                    <th>Nama Bahan</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks as $index => $stock)
                                    @php
                                        $badgeStyle = '';
                                        
                                        if ($stock->stock <= $stock->m_limit) {
                                            $badgeStyle = 'background-color: #dc3545; color: white;';
                                        } elseif ($stock->stock == $stock->m_limit + 1) {
                                            $badgeStyle = 'background-color: #ffc107; color: black;';
                                        } else {
                                            $badgeStyle = 'background-color: #198754; color: white;';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $stocks->firstItem() + $index }}</td>
                                        <td>{{ $stock->wh_name }}</td>
                                        <td>{{ $stock->m_name }}</td>
                                        <td>
                                            <span class="badge" style="{{ $badgeStyle }} padding: 6px 12px; font-size: 14px; border-radius: 4px;">{{ number_format($stock->stock) }}</span>
                                            <small class="text-muted d-block mt-1">Min: {{ number_format($stock->m_limit) }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data stok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $stocks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Notiflix.Notify.success("{{ session('success') }}");
    });
</script>
@endif

@endsection