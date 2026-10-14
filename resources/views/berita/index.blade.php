@extends('layouts.app')

@section('title', 'Berita - Teknik Informatika')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Berita dan Pengumuman</h1>
    <div class="row">
        @forelse ($berita as $b)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $b->judul }}</h5>
                        <small class="text-muted">{{ $b->published_at->format('d M Y') }}</small>
                        <p class="card-text mt-2">{{ $b->ringkasan }}</p>
                        <a href="{{ route('berita.show', $b->slug) }}" class="btn btn-sm btn-primary">Baca selengkapnya</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada berita.</p>
        @endforelse
    </div>

    {{ $berita->links() }}
</div>
@endsection