@php
  $machine = $machine ?? null;
@endphp

<div class="mb-3">
  <label for="wh_id" class="form-label">Gudang</label>
  <select name="wh_id" id="wh_id"
          class="form-select @error('wh_id') is-invalid @enderror" required>
    <option value="">-- Pilih Gudang --</option>
    @foreach($warehouses as $wh)
      <option value="{{ $wh->id }}"
        {{ (int) old('wh_id', $m->wh_id ?? '') === $wh->id ? 'selected' : '' }}>
        {{ $wh->wh_name }} ({{ $wh->branch_name }})
      </option>
    @endforeach
  </select>
  @error('wh_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="code" class="form-label">Kode Mesin</label>
  <input type="text" name="code" id="code"
         class="form-control @error('code') is-invalid @enderror"
         value="{{ old('code', $machine->code ?? '') }}" required>
  @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="name" class="form-label">Nama Mesin</label>
  <input type="text" name="name" id="name"
         class="form-control @error('name') is-invalid @enderror"
         value="{{ old('name', $machine->name ?? '') }}" required>
  @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="type" class="form-label">Tipe</label>
  <input type="text" name="type" id="type"
         class="form-control @error('type') is-invalid @enderror"
         value="{{ old('type', $machine->type ?? '') }}" required>
  @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="location" class="form-label">Satuan Counter</label>
  <input type="text" name="location" id="location"
         class="form-control @error('location') is-invalid @enderror"
         value="{{ old('location', $machine->location ?? '') }}">
  @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="status" class="form-label">Status</label>
  <select name="status" id="status"
          class="form-select @error('status') is-invalid @enderror" required>
    @foreach(['active'=>'Aktif','maintenance'=>'Maintenance','broken'=>'Rusak'] as $val => $label)
      <option value="{{ $val }}"
        {{ old('status', $machine->status ?? '') === $val ? 'selected' : '' }}>
        {{ $label }}
      </option>
    @endforeach
  </select>
  @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
