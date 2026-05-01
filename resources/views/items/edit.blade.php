@extends('layouts.app')
@section('title', 'Edit Barang')
@section('page-title', 'Edit Barang')

@section('content')
<div class="row justify-content-center">
<div class="col-xl-9">
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-pencil me-2 text-warning"></i>Edit Barang — {{ $item->name }}
        <code class="ms-2 small">{{ $item->asset_code }}</code>
    </div>
    <div class="card-body">
        <form action="{{ route('items.update', $item) }}" method="POST">
            @csrf @method('PUT')
            @include('items._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save me-1"></i>Update Barang
                </button>
                <a href="{{ route('items.show', $item) }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
