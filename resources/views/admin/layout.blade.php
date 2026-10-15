<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Admin Prodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Prodi</a>
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}" href="{{ route('admin.dosen.index') }}">Dosen</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">Berita</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.mata-kuliah.*') ? 'active' : '' }}" href="{{ route('admin.mata-kuliah.index') }}">Mata Kuliah</a></li> 
            </ul>
            <a class="btn btn-sm btn-outline-light me-2" href="{{ route('beranda') }}" target="_blank">Lihat Situs</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>