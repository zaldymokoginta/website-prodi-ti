@csrf

<div class="mb-3">
    <label class="form-label">Kode</label>
    <input type="text" name="kode" value="{{ old('kode', $mataKuliah->kode ?? '') }}"
           class="form-control @error('kode') is-invalid @enderror">
    @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Mata Kuliah</label>
    <input type="text" name="nama" value="{{ old('nama', $mataKuliah->nama ?? '') }}"
           class="form-control @error('nama') is-invalid @enderror">
    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">SKS</label>
        <input type="number" name="sks" min="1" max="6" value="{{ old('sks', $mataKuliah->sks ?? '') }}"
               class="form-control @error('sks') is-invalid @enderror">
        @error('sks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Semester</label>
        <input type="number" name="semester" min="1" max="8" value="{{ old('semester', $mataKuliah->semester ?? '') }}"
               class="form-control @error('semester') is-invalid @enderror">
        @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi (opsional)</label>
    <textarea name="deskripsi" rows="4"
              class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $mataKuliah->deskripsi ?? '') }}</textarea>
    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>