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
                                          {{-- Desktop view --}}
                                          <div class="d-none d-md-flex gap-1">
                                              <button class="btn btn-sm btn-outline-primary"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#editPurchasingModal{{ $trx->id }}">
                                                  <i class="bx bx-edit-alt me-1"></i> Edit
                                              </button>
                                              <button class="btn btn-sm btn-outline-danger"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#deletePurchasingModal{{ $trx->id }}">
                                                  <i class="bx bx-trash me-1"></i> Delete
                                              </button>
                                              <button class="btn btn-sm btn-outline-info copy-btn"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#addPurchasingModal"
                                                  data-m_id ="{{ $trx->m_id }}"
                                                  data-wh_id="{{ $trx->wh_id }}"
                                                  data-qty="{{ $trx->qty }}"
                                                  data-price="{{ $trx->price }}"
                                                  data-date="{{ $trx->date?->format('Y-m-d') }}">
                                                  <i class="bx bx-copy me-1"></i> Copy
                                              </button>
                                          </div>

                                          {{-- Mobile view (dropdown) --}}
                                          <div class="dropdown d-md-none">
                                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                  <i class="bx bx-dots-vertical-rounded"></i>
                                              </button>
                                              <div class="dropdown-menu">
                                                  <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#editPurchasingModal{{ $trx->id }}">
                                                      <i class="bx bx-edit-alt me-1"></i> Edit
                                                  </button>
                                                  <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deletePurchasingModal{{ $trx->id }}">
                                                      <i class="bx bx-trash me-1"></i> Delete
                                                  </button>
                                                  <button class="dropdown-item text-info copy-btn"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#addPurchasingModal"
                                                      data-m_id ="{{ $trx->m_id }}"
                                                      data-wh_id="{{ $trx->wh_id }}"
                                                      data-qty="{{ $trx->qty }}"
                                                      data-price="{{ $trx->price }}"
                                                      data-date="{{ $trx->date?->format('Y-m-d') }}">
                                                      <i class="bx bx-copy me-1"></i> Copy
                                                  </button>
                                              </div>
                                          </div>
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

<!-- Modal Copy Transaksi -->
<div class="modal fade" id="addPurchasingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('purchasing.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi (Copy)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="m_id_copy" class="form-label">Nama Bahan</label>
                        <select name="m_id" id="m_id" class="form-select" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->m_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wh_id_copy" class="form-label">Gudang</label>
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

<!-- Modal Edit Transaksi -->
@foreach($transactions as $trx)
<div class="modal fade" id="editPurchasingModal{{ $trx->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('purchasing.update', $trx->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="m_id{{ $trx->id }}" class="form-label">Nama Bahan</label>
                        <select name="m_id" class="form-select" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" {{ $trx->m_id == $material->id ? 'selected' : '' }}>
                                    {{ $material->m_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wh_id{{ $trx->id }}" class="form-label">Gudang</label>
                        <select name="wh_id" class="form-select" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ $trx->wh_id == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->branch_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="number" name="qty" class="form-control" value="{{ $trx->qty }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Satuan</label>
                        <input type="number" name="price" class="form-control" value="{{ $trx->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ $trx->date?->format('Y-m-d') }}" required>
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
@endforeach

<!-- Modal Hapus Transaksi -->
@foreach($transactions as $trx)
<div class="modal fade" id="deletePurchasingModal{{ $trx->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('purchasing.destroy', $trx->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
                    <p><strong>Nama Bahan:</strong> {{ $trx->material->m_name ?? '-' }}</p>
                    <p><strong>Gudang:</strong> {{ $trx->warehouse->branch_name ?? '-' }}</p>
                    <p><strong>Jumlah:</strong> {{ $trx->qty }}</p>
                    <p><strong>Harga Satuan:</strong> Rp {{ number_format($trx->price, 0, ',', '.') }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($trx->qty * $trx->price, 0, ',', '.') }}</p>
                    <p><strong>Tanggal:</strong> {{ $trx->date?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle copy button click
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function () {
                const mId = this.getAttribute('data-m_id');
                const whId = this.getAttribute('data-wh_id');
                const qty = this.getAttribute('data-qty');
                const price = this.getAttribute('data-price');
                const date = this.getAttribute('data-date');

                // Set values in the copy modal
                document.querySelector('#addPurchasingModal select[name="m_id"]').value = mId;
                document.querySelector('#addPurchasingModal select[name="wh_id"]').value = whId;
                document.querySelector('#addPurchasingModal input[name="qty"]').value = qty;
                document.querySelector('#addPurchasingModal input[name="price"]').value = price;
                document.querySelector('#addPurchasingModal input[name="date"]').value = date;
            });
        });
    });
</script>

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
