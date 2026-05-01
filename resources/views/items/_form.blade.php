{{-- Shared item form --}}
<ul class="nav nav-tabs mb-4" id="itemTab">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-umum">Umum</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-spek">Spesifikasi PC</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-spek-tambahan">Spek Tambahan</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-kondisi">Kondisi & Status</a></li>
</ul>

<div class="tab-content">
    {{-- ── Tab Umum ── --}}
    <div class="tab-pane fade show active" id="tab-umum">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $item->name ?? '') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tahun Pembelian</label>
                <input type="number" name="year_purchased" class="form-control"
                       value="{{ old('year_purchased', $item->year_purchased ?? '') }}"
                       min="1990" max="{{ date('Y') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ruangan <span class="text-danger">*</span></label>
                <select name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}"
                        {{ old('room_id', $item->room_id ?? request('room_id')) == $room->id ? 'selected' : '' }}>
                        {{ $room->code }} – {{ $room->name }}
                    </option>
                    @endforeach
                </select>
                @error('room_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $item->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Merk</label>
                <input type="text" name="brand" class="form-control"
                       value="{{ old('brand', $item->brand ?? '') }}" placeholder="Contoh: ASUS, HP">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Model</label>
                <input type="text" name="model" class="form-control"
                       value="{{ old('model', $item->model ?? '') }}" placeholder="Contoh: VivoBook 15">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Serial Number</label>
                <input type="text" name="serial_number" class="form-control"
                       value="{{ old('serial_number', $item->serial_number ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga Beli (Rp)</label>
                <input type="number" name="purchase_price" class="form-control"
                       value="{{ old('purchase_price', $item->purchase_price ?? '') }}" min="0" step="1000">
            </div>
        </div>
    </div>

    {{-- ── Tab Spesifikasi PC ── --}}
    <div class="tab-pane fade" id="tab-spek">
        <div class="alert alert-info py-2 small">
            <i class="bi bi-info-circle me-1"></i> Isi bagian ini hanya jika barang adalah komputer/PC/laptop.
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Processor (CPU)</label>
                <input type="text" name="cpu" class="form-control"
                       value="{{ old('cpu', $item->cpu ?? '') }}" placeholder="Contoh: Intel Core i5-12400">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">RAM</label>
                <input type="text" name="ram" class="form-control"
                       value="{{ old('ram', $item->ram ?? '') }}" placeholder="Contoh: 8 GB DDR4">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Storage</label>
                <input type="text" name="storage" class="form-control"
                       value="{{ old('storage', $item->storage ?? '') }}" placeholder="Contoh: 256 GB SSD">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Sistem Operasi</label>
                <input type="text" name="os" class="form-control"
                       value="{{ old('os', $item->os ?? '') }}" placeholder="Contoh: Windows 11 Pro">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">IP Address</label>
                <input type="text" name="ip_address" class="form-control @error('ip_address') is-invalid @enderror"
                       value="{{ old('ip_address', $item->ip_address ?? '') }}" placeholder="192.168.1.x">
                @error('ip_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">MAC Address</label>
                <input type="text" name="mac_address" class="form-control"
                       value="{{ old('mac_address', $item->mac_address ?? '') }}" placeholder="AA:BB:CC:DD:EE:FF">
            </div>
        </div>
    </div>

    {{-- ── Tab Spek Tambahan (dynamic key-value) ── --}}
    <div class="tab-pane fade" id="tab-spek-tambahan">
        <div class="alert alert-info py-2 small">
            <i class="bi bi-info-circle me-1"></i> Tambahkan spesifikasi lain yang tidak ada di form baku (mis: kapasitas AC, jumlah port switch, dll).
        </div>
        <div id="specs-container">
            @php $existingSpecs = old('specs', isset($item) && $item->specs ? collect($item->specs)->map(fn($v,$k)=>['key'=>$k,'value'=>$v])->values()->toArray() : []); @endphp
            @foreach($existingSpecs as $i => $spec)
            <div class="row g-2 mb-2 spec-row">
                <div class="col-md-4">
                    <input type="text" name="specs[{{ $i }}][key]" class="form-control form-control-sm"
                           placeholder="Nama spek (mis: Kapasitas)" value="{{ $spec['key'] ?? '' }}">
                </div>
                <div class="col-md-7">
                    <input type="text" name="specs[{{ $i }}][value]" class="form-control form-control-sm"
                           placeholder="Nilai (mis: 1.5 PK)" value="{{ $spec['value'] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.spec-row').remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addSpecRow()">
            <i class="bi bi-plus-lg me-1"></i>Tambah Spesifikasi
        </button>
    </div>

    {{-- ── Tab Kondisi & Status ── --}}
    <div class="tab-pane fade" id="tab-kondisi">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Kondisi <span class="text-danger">*</span></label>
                <select name="condition" class="form-select @error('condition') is-invalid @enderror" required>
                    <option value="baik" {{ old('condition', $item->condition ?? 'baik') == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ old('condition', $item->condition ?? '') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ old('condition', $item->condition ?? '') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="tidak_berfungsi" {{ old('condition', $item->condition ?? '') == 'tidak_berfungsi' ? 'selected' : '' }}>Tidak Berfungsi</option>
                </select>
                @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="aktif" {{ old('status', $item->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="perbaikan" {{ old('status', $item->status ?? '') == 'perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                    <option value="penghapusan" {{ old('status', $item->status ?? '') == 'penghapusan' ? 'selected' : '' }}>Penghapusan</option>
                    <option value="dipinjam" {{ old('status', $item->status ?? '') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal Cek Terakhir</label>
                <input type="date" name="last_checked" class="form-control"
                       value="{{ old('last_checked', isset($item) && $item->last_checked ? $item->last_checked->format('Y-m-d') : '') }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Catatan</label>
                <textarea name="notes" class="form-control" rows="3"
                          placeholder="Keterangan kondisi, kerusakan, dll...">{{ old('notes', $item->notes ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let specIndex = {{ count($existingSpecs ?? []) }};
function addSpecRow() {
    const c = document.getElementById('specs-container');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 spec-row';
    row.innerHTML = `
        <div class="col-md-4">
            <input type="text" name="specs[${specIndex}][key]" class="form-control form-control-sm" placeholder="Nama spek">
        </div>
        <div class="col-md-7">
            <input type="text" name="specs[${specIndex}][value]" class="form-control form-control-sm" placeholder="Nilai">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.spec-row').remove()">
                <i class="bi bi-x"></i>
            </button>
        </div>`;
    c.appendChild(row);
    specIndex++;
}
</script>
@endpush
