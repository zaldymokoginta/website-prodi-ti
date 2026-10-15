@extends('admin.layout')

@section('title', 'Kelola Mata Kuliah')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Mata Kuliah</h1>
    <a href="{{ route('admin.mata-kuliah.create') }}" class="btn btn-primary">+ Tambah Mata Kuliah</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($matkul as $mk)
                    <tr>
                        <td>{{ $mk->kode }}</td>
                        <td>{{ $mk->nama }}</td>
                        <td>{{ $mk->sks }}</td>
                        <td>{{ $mk->semester }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.mata-kuliah.edit', $mk) }}" class="btn btn-sm btn-warning">Ubah</a>
                            <form action="{{ route('admin.mata-kuliah.destroy', $mk) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus mata kuliah ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada mata kuliah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $matkul->links() }}</div>
@endsection