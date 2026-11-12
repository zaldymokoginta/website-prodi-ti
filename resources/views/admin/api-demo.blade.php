@extends('admin.layout')

@section('title', 'Berita via API')

@section('content')

{{-- FORM LOGIN API --}}
<div id="kartu-login" class="card mx-auto d-none" style="max-width: 420px;">
    <div class="card-body p-4">
        <h1 class="h4 mb-2">Login API</h1>
        <p class="small text-muted">Masuk untuk mendapatkan token. Token dipakai pada header <code>Authorization: Bearer</code>.</p>
        <form id="form-login">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" class="form-control" value="admin@prodi.test" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" class="form-control" required>
            </div>
            <div id="pesan-login" class="text-danger small mb-2"></div>
            <button class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</div>

{{-- AREA DATA (tampil setelah login) --}}
<div id="area-data" class="d-none">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h1 class="h3 mb-0">Berita via API</h1>
        <div class="d-flex gap-2 align-items-center">
            <span class="small text-muted" id="user-info"></span>
            <div class="btn-group" id="pilih-backend">
                <button class="btn btn-outline-primary active" data-backend="laravel">Laravel :8000</button>
                <button class="btn btn-outline-primary" data-backend="node">Node.js :3000</button>
            </div>
            <button class="btn btn-outline-danger" id="btn-logout">Logout API</button>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3" id="tab-filter">
        <li class="nav-item"><button class="nav-link active" data-status="">Semua (<span id="c-semua">-</span>)</button></li>
        <li class="nav-item"><button class="nav-link" data-status="terbit">Terbit (<span id="c-terbit">-</span>)</button></li>
        <li class="nav-item"><button class="nav-link" data-status="draft">Draft (<span id="c-draft">-</span>)</button></li>
    </ul>

    <div id="info" class="small text-muted mb-2"></div>
    <div id="daftar" class="list-group mb-4"></div>

    <div class="card d-none" id="kartu-notif">
        <div class="card-header">Notifikasi webhook (dari Node.js)</div>
        <ul class="list-group list-group-flush" id="daftar-notif"></ul>
    </div>
</div>

<script>
    const BASE = {
        laravel: window.location.origin,
        node: 'http://127.0.0.1:3000',
    };

    // sessionStorage: token hilang saat tab ditutup
    let token = sessionStorage.getItem('api_token');
    let backend = 'laravel';
    let filter = '';

    function tampilkan(sudahLogin) {
        document.getElementById('kartu-login').classList.toggle('d-none', sudahLogin);
        document.getElementById('area-data').classList.toggle('d-none', !sudahLogin);
        document.getElementById('user-info').textContent = sessionStorage.getItem('api_user') || '';
    }

    function keluarLokal(pesan) {
        token = null;
        sessionStorage.removeItem('api_token');
        sessionStorage.removeItem('api_user');
        document.getElementById('pesan-login').textContent = pesan || '';
        tampilkan(false);
    }

    async function ambil(path) {
        const res = await fetch(BASE[backend] + path, {
            headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
        });

        if (res.status === 401) {
            keluarLokal('Sesi API berakhir, silakan login lagi.');
            throw new Error('HTTP 401');
        }
        if (!res.ok) throw new Error('HTTP ' + res.status);

        return (await res.json()).data;
    }

    function baris(teks, kelas) {
        const el = document.createElement('div');
        el.className = kelas;
        el.textContent = teks;
        return el;
    }

    function tampilkanBerita(daftar) {
        const wadah = document.getElementById('daftar');
        wadah.replaceChildren();

        if (daftar.length === 0) {
            wadah.append(baris('Tidak ada berita.', 'list-group-item text-muted'));
            return;
        }

        daftar.forEach((b) => {
            const item = document.createElement('div');
            item.className = 'list-group-item d-flex justify-content-between align-items-center';

            const kiri = document.createElement('div');
            const judul = document.createElement('div');
            judul.className = 'fw-semibold';
            judul.textContent = b.judul;
            const tanggal = document.createElement('small');
            tanggal.className = 'text-muted';
            tanggal.textContent = b.published_at
                ? new Date(b.published_at).toLocaleDateString('id-ID')
                : 'Belum terbit';
            kiri.append(judul, tanggal);

            const lencana = document.createElement('span');
            lencana.className = 'badge ' + (b.status === 'terbit' ? 'bg-success' : 'bg-secondary');
            lencana.textContent = b.status === 'terbit' ? 'Terbit' : 'Draft';

            item.append(kiri, lencana);
            wadah.append(item);
        });
    }

    function tampilkanNotifikasi(daftar) {
        const ul = document.getElementById('daftar-notif');
        ul.replaceChildren();

        if (daftar.length === 0) {
            ul.append(baris('Belum ada notifikasi.', 'list-group-item text-muted'));
            return;
        }

        daftar.slice(0, 10).forEach((n) => {
            const waktu = new Date(n.diterima).toLocaleTimeString('id-ID');
            ul.append(baris(`${waktu} | ${n.event} | ${n.judul} (${n.status})`, 'list-group-item small'));
        });
    }

    async function muat() {
        if (!token) return;

        const info = document.getElementById('info');
        info.textContent = 'Memuat data dari ' + backend + '...';

        try {
            const query = filter ? '?status=' + filter : '';
            const [stat, berita] = await Promise.all([
                ambil('/api/v1/statistik'),
                ambil('/api/v1/berita' + query),
            ]);

            document.getElementById('c-semua').textContent = stat.semua;
            document.getElementById('c-terbit').textContent = stat.terbit;
            document.getElementById('c-draft').textContent = stat.draft;
            tampilkanBerita(berita);

            const kartu = document.getElementById('kartu-notif');
            if (backend === 'node') {
                kartu.classList.remove('d-none');
                tampilkanNotifikasi(await ambil('/api/v1/notifikasi'));
            } else {
                kartu.classList.add('d-none');
            }

            info.textContent = 'Terakhir diperbarui ' + new Date().toLocaleTimeString('id-ID')
                + ' (sumber: ' + backend + ')';
        } catch (e) {
            info.textContent = 'Gagal memuat dari ' + backend + ': ' + e.message
                + '. Pastikan servernya berjalan.';
        }
    }

    function aktifkan(wadahId, tombolTerpilih) {
        document.querySelectorAll('#' + wadahId + ' button').forEach((t) => t.classList.remove('active'));
        tombolTerpilih.classList.add('active');
    }

    // Login: selalu ke Laravel, yang menerbitkan token
    document.getElementById('form-login').addEventListener('submit', async (e) => {
        e.preventDefault();
        const pesan = document.getElementById('pesan-login');
        pesan.textContent = '';

        try {
            const res = await fetch(BASE.laravel + '/api/v1/login', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                }),
            });
            const json = await res.json();

            if (!res.ok) {
                pesan.textContent = json.message || 'Login gagal.';
                return;
            }

            token = json.data.token;
            sessionStorage.setItem('api_token', token);
            sessionStorage.setItem('api_user', json.data.user.name);
            document.getElementById('password').value = '';

            tampilkan(true);
            muat();
        } catch (err) {
            pesan.textContent = 'Tidak dapat menghubungi server.';
        }
    });

    document.getElementById('btn-logout').addEventListener('click', async () => {
        try {
            await fetch(BASE.laravel + '/api/v1/logout', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
            });
        } catch (err) { /* abaikan, token lokal tetap dibuang */ }

        keluarLokal('Anda sudah logout dari API.');
    });

    document.getElementById('pilih-backend').addEventListener('click', (e) => {
        const tombol = e.target.closest('button');
        if (!tombol) return;
        backend = tombol.dataset.backend;
        aktifkan('pilih-backend', tombol);
        muat();
    });

    document.getElementById('tab-filter').addEventListener('click', (e) => {
        const tombol = e.target.closest('button');
        if (!tombol) return;
        filter = tombol.dataset.status;
        aktifkan('tab-filter', tombol);
        muat();
    });

    tampilkan(!!token);
    muat();
    setInterval(muat, 5000);
</script>
@endsection