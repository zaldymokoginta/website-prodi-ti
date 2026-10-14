@csrf

<div class="mb-3">
    <label class="form-label">Nama (beserta gelar)</label>
    <input type="text" name="nama" value="{{ old('nama', $dosen->nama ?? '') }}"
           class="form-control @error('nama') is-invalid @enderror">
    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">NIDN</label>
    <input type="text" name="nidn" value="{{ old('nidn', $dosen->nidn ?? '') }}"
           class="form-control @error('nidn') is-invalid @enderror">
    @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Jabatan</label>
    <input type="text" name="jabatan" value="{{ old('jabatan', $dosen->jabatan ?? '') }}"
           class="form-control @error('jabatan') is-invalid @enderror">
    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('email', $dosen->email ?? '') }}"
           class="form-control @error('email') is-invalid @enderror">
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Bidang Keahlian</label>
    <input type="text" name="bidang_keahlian" value="{{ old('bidang_keahlian', $dosen->bidang_keahlian ?? '') }}"
           class="form-control @error('bidang_keahlian') is-invalid @enderror">
    @error('bidang_keahlian')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Foto (jpg/png, maks. 2 MB)</label>
    @if (!empty($dosen->foto))
        <div class="mb-2"><img src="{{ asset('storage/' . $dosen->foto) }}" width="80" class="rounded"></div>
    @endif
    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Batal</a>