@extends('layouts.app')

@section('title', 'Beranda - Teknik Informatika')

@push('styles')
<style>
    .section-title {
        position: relative;
        padding-bottom: .75rem;
        margin-bottom: 1.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 4px;
        background: #0d6efd;
        border-radius: 2px;
    }

    .section-title.center::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .peminatan-img {
        height: 240px;
        object-fit: cover;
        width: 100%;
        background: linear-gradient(135deg, #0d6efd, #6f42c1);
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="bg-light py-5">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Program Studi Teknik Informatika</h1>
        <p class="lead mb-0">Mencetak lulusan yang unggul, inovatif, dan siap bersaing di era digital.</p>
    </div>
</section>

{{-- SAMBUTAN + KETUA PRODI --}}
<section class="py-5" style="background: #e8f6ff;">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2 class="fw-bold text-primary section-title">Selamat Datang di Prodi Teknik Informatika</h2>
                <p>
                    Teknik Informatika merupakan perpaduan antara <em>Computer Engineering</em> dan
                    <em>Computer Science</em>. Mahasiswa dituntut mampu membangun sistem terintegrasi,
                    baik perangkat lunak maupun perangkat keras, serta memahami teori dan konsep
                    pengembangan aplikasi.
                </p>
                <p class="mb-0">
                    Mahasiswa dapat berfokus pada pengembangan perangkat lunak seperti Web Developer
                    dan Mobile Developer, atau menekuni bidang jaringan, kecerdasan buatan, dan multimedia.
                </p>
            </div>

            <div class="col-lg-4 text-center">
                @if ($kaprodi)
                @if ($kaprodi->foto)
                <img src="{{ asset('storage/' . $kaprodi->foto) }}" alt="{{ $kaprodi->nama }}"
                    class="rounded shadow mb-3" style="width: 220px; height: 270px; object-fit: cover;">
                @else
                <div class="rounded shadow mb-3 bg-primary text-white d-inline-flex align-items-center justify-content-center"
                    style="width: 220px; height: 270px; font-size: 4rem;">
                    {{ strtoupper(substr($kaprodi->nama, 0, 1)) }}
                </div>
                @endif
                <h3 class="h5 fw-bold text-primary mb-1">{{ $kaprodi->nama }}</h3>
                <p class="text-muted mb-0">Ketua Program Studi Teknik Informatika</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- VISI MISI TUJUAN --}}
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold section-title">Visi, Misi, dan Tujuan</h2>
        @include('partials.visi-misi')
    </div>
</section>

{{-- PEMINATAN --}}
@php
$peminatan = [
[
'nama' => 'Network Engineering',
'gambar' => 'network.jpg',
'tanya' => 'Apa itu Network Engineering?',
'jawab' => 'Peminatan ini membahas penerapan jaringan komputer, Internet of Things, dan keamanan komputer.',
],
[
'nama' => 'Sistem Cerdas dan Ilmu Data',
'gambar' => 'sistem-cerdas.jpg',
'tanya' => 'Sistem Cerdas dan Ilmu Data?',
'jawab' => 'Peminatan ini membahas kecerdasan buatan, pembelajaran mesin, dan analisis data untuk mendukung pengambilan keputusan.',
],
[
'nama' => 'Multimedia',
'gambar' => 'multimedia.jpg',
'tanya' => 'Apa itu Multimedia?',
'jawab' => 'Peminatan ini membahas desain grafis, animasi, video, dan pengembangan aplikasi interaktif.',
],
];
@endphp

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold section-title center text-center">Peminatan</h2>
        <div class="row g-4">
            @foreach ($peminatan as $p)
            <div class="col-md-4 text-center">
                <img src="{{ asset('images/peminatan/' . $p['gambar']) }}" alt="{{ $p['nama'] }}"
                    class="peminatan-img rounded mb-3" onerror="this.removeAttribute('src')">
                <h3 class="h5 fw-bold mb-3">{{ $p['nama'] }}</h3>

                <div class="accordion text-start" id="acc-{{ $loop->index }}">
                    <div class="accordion-item border-0">
                        <h4 class="accordion-header">
                            <button class="accordion-button collapsed bg-primary text-white"
                                type="button" data-bs-toggle="collapse"
                                data-bs-target="#acc-body-{{ $loop->index }}">
                                {{ $p['tanya'] }}
                            </button>
                        </h4>
                        <div id="acc-body-{{ $loop->index }}"
                            class="accordion-collapse collapse"
                            data-bs-parent="#acc-{{ $loop->index }}">
                            <div class="accordion-body bg-primary text-white">
                                {{ $p['jawab'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- BERITA --}}
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold section-title">Berita Terbaru</h2>
        <div class="row">
            @forelse ($beritaTerbaru as $berita)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    @if ($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                        class="card-img-top" style="height: 160px; object-fit: cover;">
                    @endif
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
    </div>
</section>

{{-- DOSEN --}}
<section class="pb-5">
    <div class="container">
        <h2 class="fw-bold section-title">Dosen</h2>
        <div class="row">
            @foreach ($dosen as $d)
            <div class="col-md-3 mb-3">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        @if ($d->foto)
                        <img src="{{ asset('storage/' . $d->foto) }}" alt="{{ $d->nama }}"
                            class="rounded-circle mb-2" width="96" height="96" style="object-fit: cover;">
                        @else
                        <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-2"
                            style="width: 96px; height: 96px; font-size: 2rem;">
                            {{ strtoupper(substr($d->nama, 0, 1)) }}
                        </div>
                        @endif
                        <h6 class="card-title">{{ $d->nama }}</h6>
                        <p class="card-text small text-muted mb-1">{{ $d->jabatan }}</p>
                        <p class="card-text small">{{ $d->bidang_keahlian }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KONTAK --}}
<section class="pb-5" id="kontak">
    <div class="container">
        <h2 class="fw-bold section-title">Kontak</h2>
        @include('partials.kontak')
    </div>
</section>

@endsection