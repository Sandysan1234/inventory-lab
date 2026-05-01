{{-- Shared form fields for create / edit --}}
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label fw-semibold">Kode Ruangan <span class="text-danger">*</span></label>
        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
               value="{{ old('code', $room->code ?? '') }}"
               placeholder="Contoh: LAB-01" required>
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label class="form-label fw-semibold">Nama Ruangan <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $room->name ?? '') }}"
               placeholder="Contoh: Laboratorium Pemrograman 1" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Tipe <span class="text-danger">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="">-- Pilih Tipe --</option>
            <option value="lab_informatika"
                {{ old('type', $room->type ?? '') == 'lab_informatika' ? 'selected' : '' }}>
                Lab Informatika
            </option>
            <option value="ruangan_lain"
                {{ old('type', $room->type ?? '') == 'ruangan_lain' ? 'selected' : '' }}>
                Ruangan Lain
            </option>
        </select>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Kapasitas PC</label>
        <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
               value="{{ old('capacity', $room->capacity ?? '') }}"
               min="1" placeholder="Jumlah PC (khusus lab)">
        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Lokasi / Gedung</label>
        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
               value="{{ old('location', $room->location ?? '') }}"
               placeholder="Contoh: Gedung A Lantai 2">
        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Deskripsi</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                  rows="3" placeholder="Keterangan tambahan...">{{ old('description', $room->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
