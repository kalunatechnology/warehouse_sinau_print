@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
@endsection


@section('content')
<div class="container-fluid flex-grow-1 container-p-y" style="min-height: calc(100vh - 120px);">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Stok</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    {{-- <form method="GET" action="{{ route('stocks.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('stocks.index') }}" class="btn btn-outline-danger">Reset</a>
                            @endif
                        </div>
                    </form> --}}
                    <div class="table-responsive mt-3">
                        <table id="datatable" class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Gudang</th>
                                    <th>Nama Gudang</th>
                                    <th>Nama Bahan</th>
                                    <th>Stok</th>
                                    <th>Stok Detail</th>
                                    <th>Stok Waste</th>
                                    <th>Stok Waste Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks as $index => $stock)
                                    <tr>
                                        <td>{{ $stocks->firstItem() + $index }}</td>
                                        <td>{{ $stock->wh_type }}</td>
                                        <td>{{ $stock->wh_name }}</td>
                                        <td>{{ $stock->m_name }}</td>
                                        <td>{{ number_format($stock->stock) }} {{ $stock->u_name }}</td>
                                        <td>{{ number_format($stock->stock * $stock->conversion) }} {{ $stock->unit_detail }}</td>
                                        <td>{{ $stock->stock * ($stock->waste / 100) }} {{ $stock->u_name }}</td>
                                        <td>{{ $stock->stock * ($stock->waste / 100) * $stock->conversion }} {{ $stock->unit_detail }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data stok.</td>
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

@section('script')
    <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
    <script>
        $(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection