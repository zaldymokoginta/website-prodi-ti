@extends('admin.layout')

@section('title', 'Ubah Dosen')

@section('content')
<h1 class="h3 mb-4">Ubah Dosen</h1>
<div class="card"><div class="card-body">
    <form action="{{ route('admin.dosen.update', $dosen) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.dosen._form')
    </form>
</div></div>
@endsection