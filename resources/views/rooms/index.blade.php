@extends('layouts.app')
@section('title', 'Ruangan & Lab')
@section('page-title', 'Ruangan & Lab')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0">Ruangan & Lab</h5>
        <div class="text-muted small">Total {{ $rooms->count() }} ruangan terdaftar</div>
    </div>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Ruangan
    </a>
</div>

<div class="row g-3">
    @forelse($rooms as $room)
    <div class="col-md-6 col-xl-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $room->name }}</h6>
                        <div class="text-muted small">{{ $room->code }}</div>
                    </div>
                    <span class="badge {{ $room->getTypeBadgeClass() }} rounded-pill">
                        {{ $room->getTypeLabel() }}
                    </span>
                </div>
                @if($room->location)
                <div class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $room->location }}</div>
                @endif
                @if($room->capacity)
                <div class="text-muted small mb-2"><i class="bi bi-pc-display me-1"></i>Kapasitas: {{ $room->capacity }} PC</div>
                @endif
                <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                    <span class="text-primary fw-semibold"><i class="bi bi-box-seam me-1"></i>{{ $room->items_count }} barang</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST"
                              onsubmit="return confirm('Hapus ruangan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-door-open fs-1 d-block mb-2 opacity-50"></i>
                Belum ada ruangan. <a href="{{ route('rooms.create') }}">Tambah sekarang</a>.
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
