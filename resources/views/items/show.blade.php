@extends('layouts.app')
@section('title', $item->name)
@section('page-title', $item->name)

@section('content')
<div class="row g-4">
    {{-- Detail panel --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-bottom d-flex align-items-center">
                <div>
                    <h6 class="fw-bold mb-0">{{ $item->name }}</h6>
                    <code class="small">{{ $item->asset_code }}</code>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <span class="badge {{ $item->getConditionBadgeClass() }}">{{ $item->getConditionLabel() }}</span>
                    <span class="badge {{ $item->getStatusBadgeClass() }}">{{ $item->getStatusLabel() }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small fw-semibold text-uppercase mb-1">Informasi Umum</div>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width:40%">Ruangan</td><td>{{ $item->room->name ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Kategori</td><td>{{ $item->category->name ?? '-' }}</td></tr>
                            <tr><td class="text-muted">Merk</td><td>{{ $item->brand ?: '-' }}</td></tr>
                            <tr><td class="text-muted">Model</td><td>{{ $item->model ?: '-' }}</td></tr>
                            <tr><td class="text-muted">Serial No.</td><td>{{ $item->serial_number ?: '-' }}</td></tr>
                            <tr><td class="text-muted">Tahun Beli</td><td>{{ $item->year_purchased ?: '-' }}</td></tr>
                            <tr><td class="text-muted">Harga Beli</td>
                                <td>{{ $item->purchase_price ? 'Rp '.number_format($item->purchase_price,0,',','.') : '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    @if($item->cpu || $item->ram || $item->storage || $item->os || $item->ip_address)
                    <div class="col-md-6">
                        <div class="text-muted small fw-semibold text-uppercase mb-1">Spesifikasi PC</div>
                        <table class="table table-sm table-borderless mb-0">
                            @if($item->cpu)<tr><td class="text-muted" style="width:40%">CPU</td><td>{{ $item->cpu }}</td></tr>@endif
                            @if($item->ram)<tr><td class="text-muted">RAM</td><td>{{ $item->ram }}</td></tr>@endif
                            @if($item->storage)<tr><td class="text-muted">Storage</td><td>{{ $item->storage }}</td></tr>@endif
                            @if($item->os)<tr><td class="text-muted">OS</td><td>{{ $item->os }}</td></tr>@endif
                            @if($item->ip_address)<tr><td class="text-muted">IP</td><td><code>{{ $item->ip_address }}</code></td></tr>@endif
                            @if($item->mac_address)<tr><td class="text-muted">MAC</td><td><code>{{ $item->mac_address }}</code></td></tr>@endif
                        </table>
                    </div>
                    @endif

                    @if($item->specs && count($item->specs))
                    <div class="col-12">
                        <div class="text-muted small fw-semibold text-uppercase mb-1">Spesifikasi Tambahan</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($item->specs as $k => $v)
                            <span class="badge bg-light text-dark border">{{ $k }}: {{ $v }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($item->notes)
                    <div class="col-12">
                        <div class="text-muted small fw-semibold text-uppercase mb-1">Catatan</div>
                        <p class="mb-0 small">{{ $item->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('items.edit', $item) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <a href="{{ route('maintenance.create', $item) }}" class="btn btn-info btn-sm">
                    <i class="bi bi-tools me-1"></i>Catat Pemeliharaan
                </a>
                <form action="{{ route('items.destroy', $item) }}" method="POST" class="ms-auto"
                      onsubmit="return confirm('Hapus barang ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Hapus</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Side info --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white fw-semibold border-bottom small text-uppercase text-muted">
                Cek Terakhir
            </div>
            <div class="card-body text-center">
                <div class="fs-3 fw-bold">
                    {{ $item->last_checked ? $item->last_checked->format('d M Y') : '—' }}
                </div>
                @if($item->last_checked)
                <div class="text-muted small">{{ $item->last_checked->diffForHumans() }}</div>
                @endif
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom d-flex align-items-center">
                <i class="bi bi-tools me-2 text-warning"></i>Riwayat Pemeliharaan
                <a href="{{ route('maintenance.create', $item) }}" class="ms-auto btn btn-sm btn-outline-info py-0">+ Catat</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($item->maintenanceLogs as $log)
                <li class="list-group-item px-3 py-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="small fw-semibold">{{ $log->getTypeLabel() }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $log->date->format('d/m/Y') }} · {{ $log->technician ?: 'Tidak dicatat' }}</div>
                            <div class="small mt-1">{{ Str::limit($log->description, 80) }}</div>
                        </div>
                        <form action="{{ route('maintenance.destroy', $log) }}" method="POST"
                              onsubmit="return confirm('Hapus log ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger border-0 p-0 ms-2" style="font-size:.8rem">
                                <i class="bi bi-x"></i>
                            </button>
                        </form>
                    </div>
                    <div class="mt-1">
                        <span class="badge bg-secondary" style="font-size:.7rem">Sebelum: {{ $log->condition_before }}</span>
                        <i class="bi bi-arrow-right mx-1 small"></i>
                        <span class="badge bg-primary" style="font-size:.7rem">Sesudah: {{ $log->condition_after }}</span>
                    </div>
                </li>
                @empty
                <li class="list-group-item text-center text-muted py-3 small">Belum ada log pemeliharaan</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
