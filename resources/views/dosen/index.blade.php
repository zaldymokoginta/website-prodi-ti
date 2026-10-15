@extends('layouts.app')

@section('title', 'Dosen - Teknik Informatika')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Dosen Program Studi</h1>
    <div class="row">
        @forelse ($dosen as $d)
        <div class="col-md-6 col-lg-3 mb-3">
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
                    <p class="small text-muted mb-1">{{ $d->jabatan }}</p>
                    <p class="small mb-1">NIDN: {{ $d->nidn }}</p>
                    <p class="small mb-1">{{ $d->bidang_keahlian }}</p>
                    @if ($d->email)
                    <a class="small" href="mailto:{{ $d->email }}">{{ $d->email }}</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p>Data dosen belum tersedia.</p>
        @endforelse
    </div>
</div>
@endsection