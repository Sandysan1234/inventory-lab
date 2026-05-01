@extends('layouts.app')
@section('title', 'Edit Ruangan')
@section('page-title', 'Edit Ruangan')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-pencil me-2 text-warning"></i>Edit Ruangan — {{ $room->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('rooms.update', $room) }}" method="POST">
            @csrf @method('PUT')
            @include('rooms._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="{{ route('rooms.show', $room) }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
