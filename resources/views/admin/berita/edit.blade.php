@extends('admin.layout')

@section('title', 'Ubah Berita')

@section('content')
<h1 class="h3 mb-4">Ubah Berita</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.berita._form')
    </form>
</div></div>
@endsection