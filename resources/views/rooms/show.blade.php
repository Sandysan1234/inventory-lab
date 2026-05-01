@extends('layouts.app')
@section('title', $room->name)
@section('page-title', $room->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">{{ $room->name }}</h5>
        <div class="text-muted small">
            {{ $room->code }} ·
            <span class="badge {{ $room->getTypeBadgeClass() }}">{{ $room->getTypeLabel() }}</span>
            @if($room->location) · {{ $room->location }} @endif
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('items.create', ['room_id' => $room->id]) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Barang
        </a>
        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

{{-- Kondisi ringkasan --}}
<div class="row g-2 mb-4">
    @php
        $condLabels = ['baik'=>['Baik','bg-success'],'rusak_ringan'=>['Rusak Ringan','bg-warning'],'rusak_berat'=>['Rusak Berat','bg-danger'],'tidak_berfungsi'=>['Tidak Berfungsi','bg-dark']];
    @endphp
    @foreach($condLabels as $key => [$label, $cls])
    <div class="col-6 col-sm-3">
        <div class="card border-0 shadow-sm text-center py-2">
            <div class="fs-3 fw-bold">{{ $byCondition[$key] ?? 0 }}</div>
            <span class="badge {{ $cls }} mx-auto">{{ $label }}</span>
        </div>
    </div>
    @endforeach
</div>

{{-- Item list --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold border-bottom">
        <i class="bi bi-list-ul me-2 text-primary"></i>Daftar Inventaris ({{ $items->total() }} item)
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Aset</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Merk/Model</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td><code class="small">{{ $item->asset_code }}</code></td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->category->name ?? '-' }}</span></td>
                        <td class="small text-muted">{{ $item->brand }} {{ $item->model }}</td>
                        <td><span class="badge {{ $item->getConditionBadgeClass() }}">{{ $item->getConditionLabel() }}</span></td>
                        <td><span class="badge {{ $item->getStatusBadgeClass() }}">{{ $item->getStatusLabel() }}</span></td>
                        <td>
                            <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-outline-primary py-0">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada barang di ruangan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($items->hasPages())
    <div class="card-footer bg-white">
        {{ $items->links() }}
    </div>
    @endif
</div>
@endsection
