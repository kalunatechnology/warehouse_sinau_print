@php
    $mc = $machineCounter ?? null;
    $valueRecordedAt = old(
        'recorded_at',
        optional($mc?->recorded_at)->format('Y-m-d\TH:i')
    );
@endphp

<div class="mb-3">
  <label for="machine_id" class="form-label">Mesin</label>
  <select name="machine_id" id="machine_id"
          class="form-select @error('machine_id') is-invalid @enderror" required>
    <option value="">Pilih Mesin...</option>
    @foreach($machines as $m)
      <option value="{{ $m->id }}"
        {{ (int) old('machine_id', $mc->machine_id ?? '') === $m->id ? 'selected' : '' }}>
        [{{ $m->code }}] {{ $m->name }}
      </option>
    @endforeach
  </select>
  @error('machine_id')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="counter" class="form-label">Nilai Counter</label>
  <input type="text" name="counter" id="counter" min="0"
         class="form-control @error('counter') is-invalid @enderror"
         value="{{ old('counter', $mc->counter ?? '') }}" required>
  @error('counter')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="recorded_at" class="form-label">Tanggal Pencatatan</label>
  <input
    type="datetime-local"
    name="recorded_at"
    id="recorded_at"
    class="form-control @error('recorded_at') is-invalid @enderror"
    value="{{ $valueRecordedAt }}"
    required
  >
  @error('recorded_at')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
