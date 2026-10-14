@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<div class="container mt-5" style="max-width: 800px;">
    <a href="{{ route('berita.index') }}" class="small">&larr; Kembali ke daftar berita</a>
    <h1 class="h3 mt-3">{{ $berita->judul }}</h1>
    <p class="text-muted">{{ $berita->published_at->format('d M Y') }}</p>
    <div>{!! nl2br(e($berita->isi)) !!}</div>
</div>
@endsection