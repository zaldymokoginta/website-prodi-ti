@extends('admin.layout')

@section('title', 'Kelola Dosen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Dosen</h1>
    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary">+ Tambah Dosen</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>NIDN</th>
                    <th>Jabatan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosen as $d)
                <tr>
                    <td>
                        @if ($d->foto)
                        <img src="{{ asset('storage/' . $d->foto) }}" alt="{{ $d->nama }}" width="48" height="48" class="rounded-circle object-fit-cover">
                        @else
                        <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->nidn }}</td>
                    <td>{{ $d->jabatan }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.dosen.edit', $d) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('admin.dosen.destroy', $d) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus dosen ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada data dosen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $dosen->links() }}</div>
@endsection