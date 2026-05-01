@extends('layouts.app')
@section('title', 'Semua Barang')
@section('page-title', 'Semua Barang')

@section('content')
{{-- Filter bar --}}
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('items.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Cari nama/kode/merk..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="room_id" class="form-select form-select-sm">
                    <option value="">Semua Ruangan</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->code }} – {{ $room->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="condition" class="form-select form-select-sm">
                    <option value="">Semua Kondisi</option>
                    <option value="baik" {{ request('condition')=='baik'?'selected':'' }}>Baik</option>
                    <option value="rusak_ringan" {{ request('condition')=='rusak_ringan'?'selected':'' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ request('condition')=='rusak_berat'?'selected':'' }}>Rusak Berat</option>
                    <option value="tidak_berfungsi" {{ request('condition')=='tidak_berfungsi'?'selected':'' }}>Tidak Berfungsi</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
                    <option value="perbaikan" {{ request('status')=='perbaikan'?'selected':'' }}>Perbaikan</option>
                    <option value="penghapusan" {{ request('status')=='penghapusan'?'selected':'' }}>Penghapusan</option>
                    <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam</option>
                </select>
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                <a href="{{ route('items.index') }}" class="btn btn-light btn-sm"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-2">
    <span class="text-muted small">{{ $items->total() }} barang ditemukan</span>
    <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tambah Barang
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Aset</th>
                        <th>Nama Barang</th>
                        <th>Ruangan</th>
                        <th>Kategori</th>
                        <th>Merk / Model</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Cek Terakhir</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td><code class="small">{{ $item->asset_code }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $item->name }}</div>
                            @if($item->serial_number)
                            <div class="text-muted" style="font-size:.74rem">S/N: {{ $item->serial_number }}</div>
                            @endif
                        </td>
                        <td class="small">{{ $item->room->code ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border small">{{ $item->category->name ?? '-' }}</span></td>
                        <td class="small text-muted">{{ $item->brand }} {{ $item->model }}</td>
                        <td><span class="badge {{ $item->getConditionBadgeClass() }}">{{ $item->getConditionLabel() }}</span></td>
                        <td><span class="badge {{ $item->getStatusBadgeClass() }}">{{ $item->getStatusLabel() }}</span></td>
                        <td class="small text-muted">{{ $item->last_checked ? $item->last_checked->format('d/m/Y') : '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-outline-primary py-0">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-warning py-0">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('items.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger py-0"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-5">Tidak ada barang ditemukan.</td></tr>
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
