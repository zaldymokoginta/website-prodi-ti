<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataKuliahController extends Controller
{
    public function index()
    {
        $matkul = MataKuliah::orderBy('semester')->orderBy('kode')->paginate(15);

        return view('admin.matkul.index', compact('matkul'));
    }

    public function create()
    {
        return view('admin.matkul.create');
    }

    public function store(Request $request)
    {
        MataKuliah::create($request->validate($this->rules()));

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return view('admin.matkul.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $mataKuliah->update($request->validate($this->rules($mataKuliah)));

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }

    private function rules(?MataKuliah $mataKuliah = null): array
    {
        return [
            'kode' => ['required', 'string', 'max:20', Rule::unique('mata_kuliah', 'kode')->ignore($mataKuliah?->id)],
            'nama' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'between:1,6'],
            'semester' => ['required', 'integer', 'between:1,8'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}