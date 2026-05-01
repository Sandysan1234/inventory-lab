@extends('layouts.app')
@section('title', 'Tambah Ruangan')
@section('page-title', 'Tambah Ruangan')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Ruangan / Lab
    </div>
    <div class="card-body">
        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf
            @include('rooms._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="{{ route('rooms.index') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
