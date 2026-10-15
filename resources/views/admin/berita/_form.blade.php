@csrf

<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="judul" value="{{ old('judul', $berita->judul ?? '') }}"
           class="form-control @error('judul') is-invalid @enderror">
    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan (maks. 500 karakter)</label>
    <textarea name="ringkasan" rows="3"
              class="form-control @error('ringkasan') is-invalid @enderror">{{ old('ringkasan', $berita->ringkasan ?? '') }}</textarea>
    @error('ringkasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Isi Berita</label>
    <textarea name="isi" rows="10"
              class="form-control @error('isi') is-invalid @enderror">{{ old('isi', $berita->isi ?? '') }}</textarea>
    @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar (jpg/png, maks. 2 MB)</label>
    @if (!empty($berita->gambar))
        <div class="mb-2"><img src="{{ asset('storage/' . $berita->gambar) }}" width="160" class="rounded"></div>
    @endif
    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
    @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    @php
        $statusSaatIni = old('status', !empty($berita->published_at) ? 'terbit' : 'draft');
    @endphp
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="draft" @selected($statusSaatIni === 'draft')>Draft (belum tampil di situs)</option>
        <option value="terbit" @selected($statusSaatIni === 'terbit')>Terbit</option>
    </select>
    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<button class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>