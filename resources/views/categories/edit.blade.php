@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-5">
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-pencil me-2 text-warning"></i>Edit Kategori — {{ $category->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Icon</label>
                <div class="input-group">
                    <span class="input-group-text" id="icon-preview">
                        <i class="bi {{ $category->icon ?: 'bi-tag' }}"></i>
                    </span>
                    <input type="text" name="icon" id="icon-input" class="form-control"
                           value="{{ old('icon', $category->icon) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">Update</button>
                <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('icon-input').addEventListener('input', function() {
    document.getElementById('icon-preview').innerHTML = `<i class="bi ${this.value || 'bi-tag'}"></i>`;
});
</script>
@endpush
