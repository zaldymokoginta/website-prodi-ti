<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $data['slug'] = $this->buatSlug($data['judul']);
        $data['published_at'] = $data['status'] === 'terbit' ? now() : null;
        unset($data['status']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate($this->rules());

        // Slug sengaja tidak diubah agar tautan lama tetap berfungsi.
        // Jika sudah terbit, pertahankan tanggal terbit aslinya.
        $data['published_at'] = $data['status'] === 'terbit'
            ? ($berita->published_at ?? now())
            : null;
        unset($data['status']);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status' => ['required', Rule::in(['draft', 'terbit'])],
        ];
    }

    private function buatSlug(string $judul): string
    {
        $asli = Str::slug($judul);
        $slug = $asli;
        $i = 2;

        while (Berita::where('slug', $slug)->exists()) {
            $slug = $asli . '-' . $i++;
        }

        return $slug;
    }
}