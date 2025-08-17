@extends('layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Riwayat Counter Mesin</h5>
      <button class="btn btn-sm btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#createLogModal">
        + Tambah Riwayat
      </button>
    </div>

    <div class="card-body">
      <form method="GET" action="{{ route('machine-counter-logs.index') }}" class="mb-3">
        <div class="input-group">
          <input type="text" name="search"
                 class="form-control"
                 placeholder="Cari kode mesin, keterangan..."
                 value="{{ $search }}">
          <button class="btn btn-outline-secondary">Cari</button>
          @if($search)
            <a href="{{ route('machine-counter-logs.index') }}"
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
              <th>Before → After</th>
              <th>Oleh</th>
              <th>Deskripsi</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $i => $log)
              <tr @if($log->trashed()) class="table-secondary" @endif>
                <td>{{ $logs->firstItem()+$i }}</td>
                <td>[{{ $log->machine->code }}] {{ $log->machine->name }} </td>
                <td>{{ $log->counter_before }} → {{ $log->counter_after }} {{ $log->machine->location }}</td>
                <td>{{ $log->user->name }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    @if(!$log->trashed())
                      <button class="btn btn-outline-primary"
                              data-bs-toggle="modal"
                              data-bs-target="#editLogModal{{ $log->id }}">
                        Edit
                      </button>
                      <button class="btn btn-outline-danger"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteLogModal{{ $log->id }}">
                        Hapus
                      </button>
                    @else
                      <form action="{{ route('machine-counter-logs.restore', $log->id) }}"
                            method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-success">Pulihkan</button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Belum ada riwayat.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($logs->hasPages())
        <div class="mt-3">{{ $logs->links('pagination::bootstrap-5') }}</div>
      @endif
    </div>
  </div>
</div>

<div class="modal fade" id="createLogModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('machine-counter-logs.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Riwayat Counter</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @include('machine_counter_logs._form', ['machineCounterLog' => null])
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

@foreach($logs as $log)
  <div class="modal fade" id="editLogModal{{ $log->id }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('machine-counter-logs.update', $log) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Riwayat Counter</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            @include('machine_counter_logs._form', ['machineCounterLog' => $log])
          </div>
          <div class="modal-footer">
            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="deleteLogModal{{ $log->id }}" tabindex="-1">
    <div class="modal-dialog">
      <form action="{{ route('machine-counter-logs.destroy', $log) }}" method="POST">
        @csrf @method('DELETE')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-danger">Hapus Riwayat</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            Yakin ingin menghapus riwayat counter mesin
            <strong>[{{ $log->machine->code }}] {{ $log->machine->name }}</strong>?
          </div>
          <div class="modal-footer">
            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-danger">Ya, Hapus</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endforeach

@if ($errors->any())
<script>document.addEventListener('DOMContentLoaded', ()=>{
    Notiflix.Notify.failure("{{ $errors->first() }}");
});</script>
@endif
@if (session('success'))
<script>document.addEventListener('DOMContentLoaded', ()=>{
    Notiflix.Notify.success("{{ session('success') }}");
});</script>
@endif
@endsection
