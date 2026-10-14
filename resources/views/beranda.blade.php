@extends('layouts.app')

@section('title', 'Beranda - Teknik Informatika')

@section('content')
<section class="bg-light py-5">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Program Studi Teknik Informatika</h1>
        <p class="lead">Mencetak lulusan yang unggul, inovatif, dan siap bersaing di era digital.</p>
        <p class="text-muted">{{ $totalMatkul }} mata kuliah &bull; {{ $dosen->count() }} dosen tampil di bawah</p>
    </div>
</section>

<div class="container mt-5">
    <h2 class="h4 mb-3">Berita Terbaru</h2>
    <div class="row">
        @forelse ($beritaTerbaru as $berita)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="text-decoration-none text-dark">{{ $berita->judul }}</a>
                    </h5>
                    <small class="text-muted">{{ $berita->published_at->format('d M Y') }}</small>
                    <p class="card-text mt-2">{{ $berita->ringkasan }}</p>
                </div>
            </div>
        </div>
        @empty
        <p>Belum ada berita.</p>
        @endforelse
    </div>

    <h2 class="h4 mt-4 mb-3">Dosen</h2>
    <div class="row">
        @foreach ($dosen as $d)
        <div class="col-md-3 mb-3">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h6 class="card-title">{{ $d->nama }}</h6>
                    <p class="card-text small text-muted mb-1">{{ $d->jabatan }}</p>
                    <p class="card-text small">{{ $d->bidang_keahlian }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection