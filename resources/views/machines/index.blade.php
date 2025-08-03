@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" style="min-height: calc(100vh - 120px);">
  <div class="row">
    <div class="col-12">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Master Mesin</h5>
          <button
            type="button"
            class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createMachineModal"
          >
            + Tambah Mesin
          </button>
        </div>

        <div class="card-body d-flex flex-column">
          <form method="GET" action="{{ route('machines.index') }}" class="mb-3">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Cari kode, nama, tipe..."
                     value="{{ request('search') }}">
              <button type="submit" class="btn btn-outline-secondary">Cari</button>
              @if(request('search'))
                <a href="{{ route('machines.index') }}" class="btn btn-outline-danger">Reset</a>
              @endif
            </div>
          </form>

          <div class="table-responsive flex-grow-1">
            <table class="table table-bordered table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Gudang</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Tipe</th>
                  <th>Lokasi</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($machines as $i => $machine)
                  <tr @if($machine->trashed()) class="table-secondary" @endif>
                    <td>{{ $machines->firstItem() + $i }}</td>
                    <td>
                      {{ $machine->warehouse->wh_name ?? '-' }}
                    </td>
                    <td>{{ $machine->code }}</td>
                    <td>{{ $machine->name }}</td>
                    <td>{{ $machine->type }}</td>
                    <td>{{ $machine->location }}</td>
                    <td>{{ ucfirst($machine->status) }}</td>
                    <td>
                      <div class="d-none d-md-flex gap-1">
                        @if(!$machine->trashed())
                          <button class="btn btn-sm btn-outline-primary"
                                  data-bs-toggle="modal"
                                  data-bs-target="#editMachineModal{{ $machine->id }}">
                            <i class="bx bx-edit-alt me-1"></i>Edit
                          </button>
                          <button class="btn btn-sm btn-outline-danger"
                                  data-bs-toggle="modal"
                                  data-bs-target="#deleteMachineModal{{ $machine->id }}">
                            <i class="bx bx-trash me-1"></i>Hapus
                          </button>
                        @else
                          <form action="{{ route('machines.restore', $machine->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">
                              <i class="bx bx-reset me-1"></i> Pulihkan
                            </button>
                          </form>
                        @endif
                      </div>

                      <div class="dropdown d-md-none">
                        <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          @if(!$machine->trashed())
                            <button class="dropdown-item text-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editMachineModal{{ $machine->id }}">
                              <i class="bx bx-edit-alt me-1"></i>Edit
                            </button>
                            <button class="dropdown-item text-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteMachineModal{{ $machine->id }}">
                              <i class="bx bx-trash me-1"></i>Hapus
                            </button>
                          @else
                            <form action="{{ route('machines.restore', $machine->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="dropdown-item text-success">
                                <i class="bx bx-reset me-1"></i> Pulihkan
                              </button>
                            </form>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center">Belum ada data mesin.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            @if ($machines->total() > 0)
              <div class="d-flex justify-content-between align-items-center mt-3 flex-column flex-md-row">
                @if ($machines->lastPage() === 1)
                  <small class="text-muted">
                    Showing {{ $machines->firstItem() }} to {{ $machines->lastItem() }}
                    of {{ $machines->total() }} entries
                  </small>
                @endif
                @if ($machines->hasPages())
                  {{ $machines->links('pagination::bootstrap-5') }}
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="createMachineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('machines.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Mesin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            @include('machines._form', [
              'machine'    => null,
              'warehouses' => $warehouses
            ])
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  @foreach($machines as $machine)
    <div class="modal fade" id="editMachineModal{{ $machine->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{ route('machines.update', $machine) }}" method="POST">
          @csrf @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Mesin</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              @include('machines._form', [
                'machine'    => $machine,
                'warehouses' => $warehouses
              ])
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="modal fade" id="deleteMachineModal{{ $machine->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{ route('machines.destroy', $machine) }}" method="POST">
          @csrf @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-danger">Hapus Mesin</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>Yakin ingin menghapus <strong>{{ $machine->name }}</strong>?</p>
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

</div>

@if ($errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Notiflix.Notify.failure("{{ $errors->first() }}");
    });
  </script>
@endif
@if (session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Notiflix.Notify.success("{{ session('success') }}");
    });
  </script>
@endif

@endsection
