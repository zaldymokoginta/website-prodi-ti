@extends('admin.layout')

@section('title', 'Tambah Berita')

@section('content')
<h1 class="h3 mb-4">Tambah Berita</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.berita._form')
    </form>
</div></div>
@endsection