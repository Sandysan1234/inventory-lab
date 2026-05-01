@extends('layouts.app')
@section('title', 'Log Pemeliharaan')
@section('page-title', 'Log Pemeliharaan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Log Pemeliharaan</h5>
    <form method="GET" class="d-flex gap-2">
        <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Semua Jenis</option>
            <option value="pemeliharaan" {{ request('type')=='pemeliharaan'?'selected':'' }}>Pemeliharaan</option>
            <option value="perbaikan" {{ request('type')=='perbaikan'?'selected':'' }}>Perbaikan</option>
            <option value="penggantian_komponen" {{ request('type')=='penggantian_komponen'?'selected':'' }}>Penggantian Komponen</option>
            <option value="pemeriksaan" {{ request('type')=='pemeriksaan'?'selected':'' }}>Pemeriksaan</option>
        </select>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Ruangan</th>
                        <th>Jenis</th>
                        <th>Teknisi</th>
                        <th>Biaya</th>
                        <th>Kondisi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="small">{{ $log->date->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('items.show', $log->item) }}" class="fw-semibold text-decoration-none">
                                {{ $log->item->name ?? '-' }}
                            </a>
                            <div class="text-muted" style="font-size:.74rem">{{ $log->item->asset_code ?? '' }}</div>
                        </td>
                        <td class="small">{{ $log->item->room->name ?? '-' }}</td>
                        <td><span class="badge {{ $log->getTypeBadgeClass() }}">{{ $log->getTypeLabel() }}</span></td>
                        <td class="small">{{ $log->technician ?: '-' }}</td>
                        <td class="small">{{ $log->cost ? 'Rp '.number_format($log->cost,0,',','.') : '-' }}</td>
                        <td class="small">
                            <span class="text-muted">{{ $log->condition_before }}</span>
                            <i class="bi bi-arrow-right mx-1"></i>
                            <strong>{{ $log->condition_after }}</strong>
                        </td>
                        <td>
                            <form action="{{ route('maintenance.destroy', $log) }}" method="POST"
                                  onsubmit="return confirm('Hapus log ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger py-0"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-5">Belum ada log pemeliharaan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
