@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Counter Mesin</h5>
      <button class="btn btn-sm btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#createCounterModal">
        + Tambah Counter
      </button>
    </div>

    <div class="card-body">
      <form method="GET" action="{{ route('machine-counters.index') }}" class="mb-3">
        <div class="input-group">
          <input type="text" name="search" class="form-control"
                 placeholder="Cari kode mesin atau nilai counter..."
                 value="{{ $search }}">
          <button type="submit" class="btn btn-outline-secondary">Cari</button>
          @if($search)
            <a href="{{ route('machine-counters.index') }}"
               class="btn btn-outline-danger">Reset</a>
          @endif
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Mesin</th>
              <th>Nilai Counter</th>
              <th>Dicatat Pada</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($counters as $i => $c)
              <tr @if($c->trashed()) class="table-secondary" @endif>
                <td>{{ $counters->firstItem() + $i }}</td>
                <td>[{{ $c->machine->code }}] {{ $c->machine->name }}</td>
                <td>{{ $c->counter }}</td>
                <td>{{ $c->recorded_at->format('Y-m-d H:i') }}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    @if(!$c->trashed())
                      <button class="btn btn-outline-primary"
                              data-bs-toggle="modal"
                              data-bs-target="#editCounterModal{{ $c->id }}">
                        Edit
                      </button>
                      <button class="btn btn-outline-danger"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteCounterModal{{ $c->id }}">
                        Hapus
                      </button>
                    @else
                      <form action="{{ route('machine-counters.restore', $c->id) }}"
                            method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">
                          Pulihkan
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada data counter.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($counters->hasPages())
        <div class="mt-3">
          {{ $counters->links('pagination::bootstrap-5') }}
        </div>
      @endif
    </div>
  </div>
</div>

<div class="modal fade" id="createCounterModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('machine-counters.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Counter Mesin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @include('machine_counters._form', ['machineCounter' => null])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary"
                  data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

@foreach($counters as $c)
  <div class="modal fade" id="editCounterModal{{ $c->id }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('machine-counters.update', $c) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Counter Mesin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            @include('machine_counters._form', ['machineCounter' => $c])
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="deleteCounterModal{{ $c->id }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('machine-counters.destroy', $c) }}" method="POST">
        @csrf @method('DELETE')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-danger">Hapus Counter Mesin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>Hapus data counter mesin <strong>{{ $c->machine->name }}</strong>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endforeach

@if ($errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Notiflix.Notify.failure("{{ $errors->first() }}");
    });
  </script>
@endif
@if (session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Notiflix.Notify.success("{{ session('success') }}");
    });
  </script>
@endif
@endsection
