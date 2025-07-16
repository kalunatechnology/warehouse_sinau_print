@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" style="min-height: calc(100vh - 120px);">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Master Gudang</h5>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createWarehouseModal"
                    >
                        + Tambah Gudang
                    </button>
                </div>
                    <div class="card-body d-flex flex-column">
                        <form method="GET" action="{{ route('warehouses.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                                @if(request('search'))
                                    <a href="{{ route('warehouses.index') }}" class="btn btn-outline-danger">Reset</a>
                                @endif
                            </div>
                        </form>
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Cabang</th>
                                    <th>Tipe Gudang</th>
                                    <th>Nama Gudang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouses as $index => $warehouse)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $warehouse->branch_name }}</td>
                                        <td>{{ $warehouse->wh_type }}</td>
                                        <td>{{ $warehouse->wh_name }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editWarehouseModal{{ $warehouse->id }}">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteWarehouseModal{{ $warehouse->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data gudang belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($warehouses->total() > 0)
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-column flex-md-row">
                                @if ($warehouses->lastPage() === 1)
                                    <div>
                                        <small class="text-muted">
                                            Showing {{ $warehouses->firstItem() }} to {{ $warehouses->lastItem() }}
                                            of {{ $warehouses->total() }} results
                                        </small>
                                    </div>
                                @endif

                                @if ($warehouses->lastPage() > 1)
                                    <div>
                                        {{ $warehouses->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL CREATE ========== -->
<div class="modal fade" id="createWarehouseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('warehouses.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Gudang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="branch_name" class="form-label">Nama Cabang</label>
              <input type="text" id="branch_name" name="branch_name" class="form-control" required>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-3">
              <label for="wh_type" class="form-label">Tipe Gudang</label>
              <select id="wh_type" name="wh_type" class="form-select" required>
                <option value="" disabled selected>-- Pilih Tipe --</option>
                <option value="Gudang Barang">Gudang Barang</option>
                <option value="Gudang Jasa">Gudang Jasa</option>
              </select>
            </div>
            <div class="col mb-3">
              <label for="wh_name" class="form-label">Nama Gudang</label>
              <input type="text" id="wh_name" name="wh_name" class="form-control" required>
            </div>
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

<!-- ========== MODAL EDIT DAN DELETE PER ITEM ========== -->
@foreach($warehouses as $warehouse)
<!-- Modal Edit -->
<div class="modal fade" id="editWarehouseModal{{ $warehouse->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Gudang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="branch_name{{ $warehouse->id }}" class="form-label">Nama Cabang</label>
              <input type="text" id="branch_name{{ $warehouse->id }}" name="branch_name" class="form-control" value="{{ $warehouse->branch_name }}" required>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-3">
              <label for="wh_type{{ $warehouse->id }}" class="form-label">Tipe Gudang</label>
              <select id="wh_type{{ $warehouse->id }}" name="wh_type" class="form-select" required>
                <option value="Gudang Barang" {{ $warehouse->wh_type == 'Gudang Barang' ? 'selected' : '' }}>Gudang Barang</option>
                <option value="Gudang Jasa" {{ $warehouse->wh_type == 'Gudang Jasa' ? 'selected' : '' }}>Gudang Jasa</option>
              </select>
            </div>
            <div class="col mb-3">
              <label for="wh_name{{ $warehouse->id }}" class="form-label">Nama Gudang</label>
              <input type="text" id="wh_name{{ $warehouse->id }}" name="wh_name" class="form-control" value="{{ $warehouse->wh_name }}" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteWarehouseModal{{ $warehouse->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus <strong>{{ $warehouse->wh_name }}</strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach
@endsection
