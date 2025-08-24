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
                        <h5 class="mb-0">Master Bahan</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createMaterialModal">
                            + Tambah Bahan
                        </button>
                    </div>
                    <div class="card-body d-flex flex-column">
                        {{-- <form method="GET" action="{{ route('materials.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary">Cari</button>
                            @if (request('search'))
                                <a href="{{ route('materials.index') }}" class="btn btn-outline-danger">Reset</a>
                            @endif
                        </div>
                    </form> --}}
                        <div class="table-responsive mt-3">
                            <table id="datatable" class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Bahan</th>
                                        <th>Nama Bahan</th>
                                        <th>Jenis</th>
                                        <th>Supplier</th>
                                        <th>Satuan</th>
                                        <th>Konversi</th>
                                        <th>Waste</th>
                                        <th>Stok Minimum</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($materials as $index => $material)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $material->m_code }}</td>
                                            <td>{{ $material->m_name }}</td>
                                            <td>{{ $material->m_type }}</td>
                                            <td>{{ $material->m_supplier ? $material->m_supplier : '-' }}</td>
                                            <td>{{ $material->unit->u_name }}</td>
                                            <td>{{ number_format($material->conversion, 0) }} {{ $material->unit_detail }}
                                            </td>
                                            <td>{{ $material->waste }} {{ $material->unit_detail }} </td>
                                            <td>{{ $material->m_limit ? $material->m_limit : 0 }}
                                                {{ $material->unit_detail }}</td>
                                            <td>
                                                {{-- Desktop view --}}
                                                <div class="d-none d-md-flex gap-1">
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editMaterialModal{{ $material->id }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteMaterialModal{{ $material->id }}">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info copy-btn"
                                                        data-bs-toggle="modal" data-bs-target="#addMaterialModal"
                                                        data-code="{{ $material->m_code }}"
                                                        data-name="{{ $material->m_name }}"
                                                        data-type="{{ $material->m_type }}"
                                                        data-supplier="{{ $material->m_supplier }}"
                                                        data-unit_id="{{ $material->unit_id }}"
                                                        data-unit-detail="{{ $material->unit_detail }}"
                                                        data-conversion="{{ $material->conversion }}"
                                                        data-waste="{{ $material->waste }}"
                                                        data-limit="{{ $material->m_limit }}">
                                                        <i class="bx bx-copy me-1"></i> Copy
                                                    </button>
                                                </div>

                                                {{-- Mobile view (dropdown) --}}
                                                <div class="dropdown d-md-none">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editMaterialModal{{ $material->id }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                                        </button>
                                                        <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteMaterialModal{{ $material->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                        <button class="dropdown-item text-info copy-btn"
                                                            data-bs-toggle="modal" data-bs-target="#addMaterialModal"
                                                            data-code="{{ $material->m_code }}"
                                                            data-name="{{ $material->m_name }}"
                                                            data-price="{{ $material->m_price }}"
                                                            data-type="{{ $material->m_type }}"
                                                            data-supplier="{{ $material->m_supplier }}"
                                                            data-unit_id="{{ $material->unit_id }}"
                                                            data-unit-detail="{{ $material->unit_detail }}"
                                                            data-conversion="{{ $material->conversion }}"
                                                            data-waste="{{ $material->waste }}"
                                                            data-limit="{{ $material->m_limit }}">
                                                            <i class="bx bx-copy me-1"></i> Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada data bahan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- {{ $materials->links('pagination::bootstrap-5') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="createMaterialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Bahan <span class="text-danger">*</span> </label>
                            <input type="text" name="m_code" class="form-control" placeholder="Masukkan Kode Bahan"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Bahan <span class="text-danger">*</span> </label>
                            <input type="text" name="m_name" class="form-control" placeholder="Masukkan Nama Bahan"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis <span class="text-danger">*</span> </label>
                            <input type="text" name="m_type" class="form-control"
                                placeholder="Masukkan Jenis Barang" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier </label>
                            <input type="text" name="m_supplier" class="form-control"
                                placeholder="Masukkan Supplier">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Satuan <span class="text-danger">*</span> </label>
                            <select name="unit_id" class="form-control" required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->u_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Detail Satuan <span class="text-danger">*</span> </label>
                            <input type="text" name="unit_detail" class="form-control unit-input"
                                placeholder="Masukkan Detail Satuan" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label unit-label">Konversi </label>
                            <input type="number" step="0.01" name="conversion" placeholder="Masukkan Konversi"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label unit-label">Waste </label>
                            <input type="number" name="waste" class="form-control" placeholder="Masukkan Bahan Sisa"
                                step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label unit-label">Minimum Stok </label>
                            <input type="number" name="m_limit" class="form-control"
                                placeholder="Masukkan Batas Minimum Stok">
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

    <!-- Copy -->
    <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Bahan <span class="text-danger">*</span> </label>
                            <input type="text" id="m_code" name="m_code" class="form-control" placeholder="Masukkan Kode Bahan"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Bahan <span class="text-danger">*</span> </label>
                            <input type="text" name="m_name" id="m_name" class="form-control" placeholder="Masukkan Nama Bahan"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis <span class="text-danger">*</span> </label>
                            <input type="text" name="m_type" id="m_type" class="form-control"
                                placeholder="Masukkan Jenis Barang" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier </label>
                            <input type="text" id="m_supplier" name="m_supplier" class="form-control"
                                placeholder="Masukkan Supplier">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Satuan <span class="text-danger">*</span> </label>
                            <select name="unit_id" id="unit_id" class="form-control" required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->u_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Detail Satuan <span class="text-danger">*</span> </label>
                            <input type="text" id="unit_detail" name="unit_detail" class="form-control unit-input"
                                placeholder="Masukkan Detail Satuan" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label unit-label">Konversi </label>
                            <input type="number" step="0.01" id="conversion" name="conversion" placeholder="Masukkan Konversi"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label unit-label">Waste </label>
                            <input type="number" name="waste" id="waste" class="form-control" placeholder="Masukkan Bahan Sisa"
                                step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label unit-label">Minimum Stok </label>
                            <input type="number" id="m_limit" name="m_limit" class="form-control"
                                placeholder="Masukkan Batas Minimum Stok">
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


    @foreach ($materials as $material)
        <!-- Edit Modal -->
        <div class="modal fade" id="editMaterialModal{{ $material->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('materials.update', $material->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Bahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Bahan <span class="text-danger">*</span> </label>
                                <input type="text" value="{{ $material->m_code }}" name="m_code" class="form-control" placeholder="Masukkan Kode Bahan"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Bahan <span class="text-danger">*</span> </label>
                                <input type="text" name="m_name" value="{{ $material->m_name }}" class="form-control" placeholder="Masukkan Nama Bahan"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis <span class="text-danger">*</span> </label>
                                <input type="text" name="m_type" value="{{ $material->m_type }}" class="form-control"
                                    placeholder="Masukkan Jenis Barang" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier </label>
                                <input type="text" value="{{ $material->m_supplier }}" name="m_supplier" class="form-control"
                                    placeholder="Masukkan Supplier">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Satuan</label>
                                <select name="unit_id" class="form-control">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $material->unit_id == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->u_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Detail Satuan <span class="text-danger">*</span> </label>
                                <input type="text" value="{{ $material->unit_detail }}" name="unit_detail" class="form-control unit-input"
                                    placeholder="Masukkan Detail Satuan" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label unit-label">Konversi </label>
                                <input type="number" step="0.01" value="{{ $material->conversion }}" name="conversion" placeholder="Masukkan Konversi"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label unit-label">Waste </label>
                                <input type="number" name="waste" value="{{ $material->waste }}" class="form-control" placeholder="Masukkan Bahan Sisa"
                                    step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label unit-label">Minimum Stok </label>
                                <input type="number" value="{{ $material->m_limit }}" name="m_limit" class="form-control"
                                    placeholder="Masukkan Batas Minimum Stok">
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
        <div class="modal fade" id="deleteMaterialModal{{ $material->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">Hapus Bahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin ingin menghapus <strong>{{ $material->m_name }}</strong>?</p>
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

    <script>
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('m_code').value = this.dataset.code;
                document.getElementById('m_name').value = this.dataset.name;
                document.getElementById('m_type').value = this.dataset.type;
                document.getElementById('m_supplier').value = this.dataset.supplier;
                document.getElementById('unit_id').value = this.dataset.unit_id;
                document.getElementById('unit_detail').value = this.dataset['unitDetail'];
                document.getElementById('conversion').value = this.dataset.conversion;
                document.getElementById('waste').value = this.dataset.waste;
                document.getElementById('m_limit').value = this.dataset.limit;
            });
        });
    </script>

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

    <script>
        const unitInput = document.querySelector('.unit-input');
        const unitLabels = document.querySelectorAll('.unit-label');

        unitInput.addEventListener('input', function() {
            const satuan = unitInput.value.trim();
            unitLabels.forEach(label => {
                const baseText = label.dataset.base || label.innerHTML.split('(')[0].trim();
                label.dataset.base = baseText;

                if (satuan) {
                    label.innerHTML = `${baseText} (${satuan}) <span class="text-danger">*</span>`;
                } else {
                    label.innerHTML = baseText;
                    if (baseText.startsWith("Konversi")) {
                        label.innerHTML += ' <span class="text-danger">*</span>';
                    }
                }
            });
        });
    </script>
@endsection
