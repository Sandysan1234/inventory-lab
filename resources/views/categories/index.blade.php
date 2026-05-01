@extends('layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Kategori Barang')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Kategori
            </div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Contoh: PC, Monitor, Switch" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon Bootstrap</label>
                        <div class="input-group">
                            <span class="input-group-text" id="icon-preview"><i class="bi bi-tag"></i></span>
                            <input type="text" name="icon" id="icon-input" class="form-control"
                                   value="{{ old('icon') }}" placeholder="bi-pc-display">
                        </div>
                        <div class="form-text">Nama class icon dari Bootstrap Icons, mis: <code>bi-pc-display</code></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-tags me-2 text-primary"></i>Daftar Kategori
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Kategori</th><th>Deskripsi</th><th class="text-center">Jumlah Barang</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td>
                                <i class="bi {{ $cat->icon ?: 'bi-tag' }} me-2 text-primary"></i>
                                <strong>{{ $cat->name }}</strong>
                            </td>
                            <td class="small text-muted">{{ $cat->description ?: '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">{{ $cat->items_count }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning py-0">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                                          onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger py-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('icon-input').addEventListener('input', function() {
    const preview = document.getElementById('icon-preview');
    preview.innerHTML = `<i class="bi ${this.value || 'bi-tag'}"></i>`;
});
</script>
@endpush
