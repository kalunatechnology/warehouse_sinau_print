@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" style="min-height: calc(100vh - 120px);">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Master Satuan</h5>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createUnitModal"
                    >
                        + Tambah Satuan
                    </button>
                </div>
                <div class="card-body d-flex flex-column">
                    <form method="GET" action="{{ route('units.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('units.index') }}" class="btn btn-outline-danger">Reset</a>
                            @endif
                        </div>
                    </form>
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($units as $index => $unit)
                                    <tr>
                                        <td>{{ $units->firstItem() + $index }}</td>
                                        <td>{{ $unit->u_name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUnitModal{{ $unit->id }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteUnitModal{{ $unit->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data satuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($units->total() > 0)
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-column flex-md-row">
                                @if ($units->lastPage() === 1)
                                    <div>
                                        <small class="text-muted">
                                            Showing {{ $units->firstItem() }} to {{ $units->lastItem() }} of {{ $units->total() }} results
                                        </small>
                                    </div>
                                @endif

                                @if ($units->lastPage() > 1)
                                    <div>
                                        {{ $units->links('pagination::bootstrap-5') }}
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

<!-- Modal Tambah -->
<div class="modal fade" id="createUnitModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('units.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Satuan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="u_name" class="form-label">Nama Satuan</label>
            <input type="text" name="u_name" id="u_name" class="form-control" required>
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

<!-- Modal Edit dan Hapus -->
@foreach($units as $unit)
<!-- Edit Modal -->
<div class="modal fade" id="editUnitModal{{ $unit->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('units.update', $unit->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Satuan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="u_name{{ $unit->id }}" class="form-label">Nama Satuan</label>
            <input type="text" name="u_name" id="u_name{{ $unit->id }}" class="form-control" value="{{ $unit->u_name }}" required>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteUnitModal{{ $unit->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Hapus Satuan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus <strong>{{ $unit->u_name }}</strong>?</p>
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
