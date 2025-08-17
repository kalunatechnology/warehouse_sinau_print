@php
    $log = $machineCounterLog ?? null;
@endphp

<div class="mb-3">
  <label for="machine_id" class="form-label">Mesin</label>
  <select name="machine_id" id="machine_id"
          class="form-select @error('machine_id') is-invalid @enderror" required>
    <option value="">Pilih Mesin…</option>
    @foreach($machines as $m)
      <option value="{{ $m->id }}"
        {{ old('machine_id', $log->machine_id ?? '') == $m->id ? 'selected' : '' }}>
        [{{ $m->code }}] {{ $m->name }}
      </option>
    @endforeach
  </select>
  @error('machine_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3 row">
  <div class="col">
    <label for="counter_before" class="form-label">Counter Sebelumnya</label>
    <input type="text" name="counter_before" id="counter_before" min="0"
           class="form-control @error('counter_before') is-invalid @enderror"
           value="{{ old('counter_before', $log->counter_before ?? '') }}" required>
    @error('counter_before') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
  <div class="col">
    <label for="counter_after" class="form-label">Counter Baru</label>
    <input type="text" name="counter_after" id="counter_after" min="0"
           class="form-control @error('counter_after') is-invalid @enderror"
           value="{{ old('counter_after', $log->counter_after ?? '') }}" required>
    @error('counter_after') <div class="invalid-feedback">{{ $message }}</div> @enderror
  </div>
</div>

<div class="mb-3">
  <label for="description" class="form-label">Keterangan (opsional)</label>
  <input type="text" name="description" id="description"
         class="form-control @error('description') is-invalid @enderror"
         value="{{ old('description', $log->description ?? '') }}">
  @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
