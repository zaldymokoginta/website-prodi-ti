@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4">Dashboard</h1>
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-center"><div class="card-body">
            <div class="display-6">{{ $totalDosen }}</div><div class="text-muted">Dosen</div>
        </div></div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center"><div class="card-body">
            <div class="display-6">{{ $totalBerita }}</div><div class="text-muted">Berita</div>
        </div></div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center"><div class="card-body">
            <div class="display-6">{{ $totalMatkul }}</div><div class="text-muted">Mata Kuliah</div>
        </div></div>
    </div>
</div>
@endsection