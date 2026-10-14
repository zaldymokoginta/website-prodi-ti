@extends('layouts.app')

@section('title', 'Mata Kuliah - Teknik Informatika')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Mata Kuliah</h1>

    @forelse ($perSemester as $semester => $daftar)
        <h2 class="h5 mt-4">Semester {{ $semester }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th style="width: 15%">Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th style="width: 10%">SKS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftar as $mk)
                        <tr>
                            <td>{{ $mk->kode }}</td>
                            <td>{{ $mk->nama }}</td>
                            <td>{{ $mk->sks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p>Data mata kuliah belum tersedia.</p>
    @endforelse
</div>
@endsection