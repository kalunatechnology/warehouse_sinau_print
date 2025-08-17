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
                        <h5 class="mb-0">Master Gudang</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createWarehouseModal">
                            + Tambah Gudang
                        </button>
                    </div>
                    <div class="card-body d-flex flex-column">
                        {{-- <form method="GET" action="{{ route('warehouses.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                                @if (request('search'))
                                    <a href="{{ route('warehouses.index') }}" class="btn btn-outline-danger">Reset</a>
                                @endif
                            </div>
                        </form> --}}
                        <div class="table-responsive mt-3">
                            <table id="datatable" class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Cabang</th>
                                        <th>Jenis Gudang</th>
                                        <th>Nama Gudang</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($warehouses as $index => $warehouse)
                                        <tr>
                                            <td>{{ $warehouses->firstItem() + $index }}</td>
                                            <td>{{ $warehouse->branch_name }}</td>
                                            <td>{{ $warehouse->wh_type }}</td>
                                            <td>{{ $warehouse->wh_name }}</td>
                                            <td>{{ $warehouse->address ?? '-' }}</td>
                                            <td>
                                                {{-- Desktop view --}}
                                                <div class="d-none d-md-flex gap-1">
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editWarehouseModal{{ $warehouse->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteWarehouseModal{{ $warehouse->id }}">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </div>

                                                {{-- Mobile view --}}
                                                <div class="dropdown d-md-none">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editWarehouseModal{{ $warehouse->id }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                                        </button>
                                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteWarehouseModal{{ $warehouse->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data gudang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- @if ($warehouses->total() > 0)
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
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
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
                        <div class="mb-3">
                            <label for="branch_name" class="form-label">Cabang <span class="text-danger">*</span> </label>
                            <input type="text" name="branch_name" class="form-control" placeholder="Masukkan Nama Cabang"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="wh_type" class="form-label">Jenis Gudang <span class="text-danger">*</span>
                            </label>
                            <select name="wh_type" class="form-select" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Gudang Barang">Gudang Barang</option>
                                <option value="Gudang Jasa">Gudang Jasa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="wh_name" class="form-label">Nama Gudang <span class="text-danger">*</span> </label>
                            <input type="text" name="wh_name" class="form-control" placeholder="Masukkan Nama Gudang"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat </label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan Alamat"></textarea>
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

    <!-- Modal Edit dan Delete -->
    @foreach ($warehouses as $warehouse)
        <!-- Edit Modal -->
        <div class="modal fade" id="editWarehouseModal{{ $warehouse->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Gudang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="branch_name{{ $warehouse->id }}" class="form-label">Cabang <span class="text-danger">*</span> </label>
                                <input type="text" name="branch_name" class="form-control"
                                    value="{{ $warehouse->branch_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="wh_type{{ $warehouse->id }}" class="form-label">Jenis Gudang <span class="text-danger">*</span> </label>
                                <select name="wh_type" class="form-select" required>
                                    <option value="Gudang Barang"
                                        {{ $warehouse->wh_type == 'Gudang Barang' ? 'selected' : '' }}>Gudang Barang
                                    </option>
                                    <option value="Gudang Jasa"
                                        {{ $warehouse->wh_type == 'Gudang Jasa' ? 'selected' : '' }}>Gudang Jasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="wh_name{{ $warehouse->id }}" class="form-label">Nama Gudang <span class="text-danger">*</span> </label>
                                <input type="text" name="wh_name" class="form-control"
                                    value="{{ $warehouse->wh_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address{{ $warehouse->id }}" class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Masukkan Alamat">{{ $warehouse->address }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteWarehouseModal{{ $warehouse->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">Hapus Gudang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin ingin menghapus <strong>{{ $warehouse->wh_name }}</strong>?</p>
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

@section('script')
    <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
    <script>
        $(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
