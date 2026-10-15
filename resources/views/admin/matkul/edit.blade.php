@extends('admin.layout')

@section('title', 'Ubah Mata Kuliah')

@section('content')
<h1 class="h3 mb-4">Ubah Mata Kuliah</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('admin.mata-kuliah.update', $mataKuliah) }}" method="POST">
        @method('PUT')
        @include('admin.matkul._form')
    </form>
</div></div>
@endsection