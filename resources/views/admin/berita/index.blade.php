@extends('admin.layout')

@section('title', 'Kelola Berita')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Berita</h1>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">+ Tambah Berita</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal Terbit</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($berita as $b)
                    <tr>
                        <td>{{ $b->judul }}</td>
                        <td>
                            @if ($b->published_at)
                                <span class="badge bg-success">Terbit</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>{{ $b->published_at?->format('d M Y') ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.berita.edit', $b) }}" class="btn btn-sm btn-warning">Ubah</a>
                            <form action="{{ route('admin.berita.destroy', $b) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $berita->links() }}</div>
@endsection