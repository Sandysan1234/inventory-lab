@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10">
                    <i class="bi bi-box-seam text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $totalItems }}</div>
                    <div class="text-muted small">Total Barang</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10">
                    <i class="bi bi-check-circle text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $byCondition['baik'] ?? 0 }}</div>
                    <div class="text-muted small">Kondisi Baik</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger bg-opacity-10">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold lh-1">
                        {{ ($byCondition['rusak_berat'] ?? 0) + ($byCondition['tidak_berfungsi'] ?? 0) }}
                    </div>
                    <div class="text-muted small">Perlu Perhatian</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10">
                    <i class="bi bi-door-open text-info"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold lh-1">{{ $totalRooms }}</div>
                    <div class="text-muted small">{{ $labRooms }} Lab + {{ $totalRooms - $labRooms }} Ruangan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Kondisi barang --}}
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-pie-chart me-2 text-primary"></i>Kondisi Barang
            </div>
            <div class="card-body">
                @php
                    $conditions = [
                        'baik'            => ['label'=>'Baik',             'class'=>'bg-success'],
                        'rusak_ringan'    => ['label'=>'Rusak Ringan',     'class'=>'bg-warning'],
                        'rusak_berat'     => ['label'=>'Rusak Berat',      'class'=>'bg-danger'],
                        'tidak_berfungsi' => ['label'=>'Tidak Berfungsi',  'class'=>'bg-dark'],
                    ];
                @endphp
                @foreach($conditions as $key => $info)
                    @php $count = $byCondition[$key] ?? 0; $pct = $totalItems > 0 ? round($count/$totalItems*100) : 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small">{{ $info['label'] }}</span>
                            <span class="small fw-semibold">{{ $count }} ({{ $pct }}%)</span>
                        </div>
                        <div class="progress" style="height:8px">
                            <div class="progress-bar {{ $info['class'] }}" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Barang per ruangan --}}
    <div class="col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-building me-2 text-primary"></i>Inventaris per Ruangan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ruangan</th>
                                <th>Tipe</th>
                                <th class="text-end">Barang</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($byRoom as $room)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $room->name }}</div>
                                    <div class="text-muted small">{{ $room->code }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $room->getTypeBadgeClass() }} rounded-pill">
                                        {{ $room->getTypeLabel() }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">{{ $room->items_count }}</td>
                                <td>
                                    <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-primary py-0">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada ruangan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Barang bermasalah --}}
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold border-bottom d-flex align-items-center">
                <i class="bi bi-exclamation-triangle text-danger me-2"></i>Barang Bermasalah
                <a href="{{ route('items.index', ['condition' => 'rusak_berat']) }}" class="ms-auto btn btn-sm btn-outline-danger py-0">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr><th>Barang</th><th>Ruangan</th><th>Kondisi</th></tr>
                        </thead>
                        <tbody>
                            @forelse($damagedItems as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('items.show', $item) }}" class="fw-semibold text-decoration-none">{{ $item->name }}</a>
                                    <div class="text-muted small">{{ $item->asset_code }}</div>
                                </td>
                                <td class="small">{{ $item->room->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $item->getConditionBadgeClass() }}">{{ $item->getConditionLabel() }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3"><i class="bi bi-check-circle text-success"></i> Tidak ada barang bermasalah</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Log terbaru --}}
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold border-bottom d-flex align-items-center">
                <i class="bi bi-tools text-warning me-2"></i>Pemeliharaan Terbaru
                <a href="{{ route('maintenance.index') }}" class="ms-auto btn btn-sm btn-outline-secondary py-0">Semua</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($recentMaintenance as $log)
                <li class="list-group-item px-3 py-2">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold small">{{ $log->item->name ?? '-' }}</span>
                        <span class="badge {{ $log->getTypeBadgeClass() }} small">{{ $log->getTypeLabel() }}</span>
                    </div>
                    <div class="text-muted" style="font-size:.78rem">
                        {{ $log->item->room->name ?? '-' }} · {{ $log->date->format('d/m/Y') }}
                    </div>
                </li>
                @empty
                <li class="list-group-item text-center text-muted py-3">Belum ada log</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
