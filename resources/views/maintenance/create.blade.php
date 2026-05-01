@extends('layouts.app')
@section('title', 'Catat Pemeliharaan')
@section('page-title', 'Catat Pemeliharaan')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body py-2 px-3">
        <div class="small text-muted">Barang</div>
        <div class="fw-bold">{{ $item->name }}</div>
        <div class="d-flex gap-2">
            <code class="small">{{ $item->asset_code }}</code>
            <span class="badge {{ $item->getConditionBadgeClass() }}">{{ $item->getConditionLabel() }}</span>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-tools me-2 text-warning"></i>Catat Log Pemeliharaan
    </div>
    <div class="card-body">
        <form action="{{ route('maintenance.store', $item) }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                           value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jenis Pemeliharaan <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="pemeliharaan" {{ old('type')=='pemeliharaan'?'selected':'' }}>Pemeliharaan</option>
                        <option value="perbaikan" {{ old('type')=='perbaikan'?'selected':'' }}>Perbaikan</option>
                        <option value="penggantian_komponen" {{ old('type')=='penggantian_komponen'?'selected':'' }}>Penggantian Komponen</option>
                        <option value="pemeriksaan" {{ old('type')=='pemeriksaan'?'selected':'' }}>Pemeriksaan</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Teknisi</label>
                    <input type="text" name="technician" class="form-control"
                           value="{{ old('technician') }}" placeholder="Nama teknisi / vendor">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Biaya (Rp)</label>
                    <input type="number" name="cost" class="form-control"
                           value="{{ old('cost') }}" min="0" step="1000">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi Sebelum <span class="text-danger">*</span></label>
                    <select name="condition_before" class="form-select" required>
                        <option value="baik" {{ $item->condition=='baik'?'selected':'' }}>Baik</option>
                        <option value="rusak_ringan" {{ $item->condition=='rusak_ringan'?'selected':'' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ $item->condition=='rusak_berat'?'selected':'' }}>Rusak Berat</option>
                        <option value="tidak_berfungsi" {{ $item->condition=='tidak_berfungsi'?'selected':'' }}>Tidak Berfungsi</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi Sesudah <span class="text-danger">*</span></label>
                    <select name="condition_after" class="form-select" required>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="tidak_berfungsi">Tidak Berfungsi</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi / Tindakan <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="4" required placeholder="Jelaskan tindakan yang dilakukan...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save me-1"></i>Simpan Log
                </button>
                <a href="{{ route('items.show', $item) }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
