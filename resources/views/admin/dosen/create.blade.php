@extends('admin.layout')

@section('title', 'Tambah Dosen')

@section('content')
<h1 class="h3 mb-4">Tambah Dosen</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('admin.dosen.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.dosen._form')
    </form>
</div></div>
@endsection