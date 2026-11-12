# Website Profil Program Studi Teknik Informatika

Website profil program studi yang dibangun dengan Laravel 13, MySQL, dan Bootstrap 5.

## Fitur

**Halaman publik**

- Beranda, Profil (visi, misi, tujuan), Dosen, Mata Kuliah per semester, Berita (daftar dan detail), Kontak

**Halaman admin** (perlu login)

- Dashboard ringkasan data
- CRUD Dosen (dengan upload foto)
- CRUD Berita (slug otomatis, status draft/terbit, upload gambar)
- CRUD Mata Kuliah

## Kebutuhan

- PHP 8.3 atau lebih baru
- Composer
- MySQL / MariaDB
- Disarankan memakai Laragon (Windows)

## Cara menjalankan

1. Unduh proyek:

```
   git clone https://github.com/zaldymokoginta/website-prodi-ti.git
   cd website-prodi-ti
```

2. Pasang dependensi:

```
   composer install
```

3. Salin file konfigurasi dan buat kunci aplikasi:

```
   copy .env.example .env
   php artisan key:generate
```

4. Buat database kosong bernama `prodi_ti` di MySQL, lalu sesuaikan `DB_USERNAME` dan `DB_PASSWORD` di file `.env` jika berbeda.
5. Buat tabel dan isi data contoh:

```
   php artisan migrate --seed
```

6. Hubungkan folder penyimpanan untuk upload foto:

```
   php artisan storage:link
```

7. Jalankan server lokal:

```
   php artisan serve
```

8. Buka `http://127.0.0.1:8000`.

## Akun admin demo

Buka `http://127.0.0.1:8000/login`

- Email: `admin@prodi.test`
- Password: `password123`

> Akun ini hanya untuk percobaan lokal.

## Struktur singkat

| Lokasi                        | Fungsi                              |
| ----------------------------- | ----------------------------------- |
| `routes/web.php`              | Daftar route publik dan admin       |
| `app/Http/Controllers/`       | Controller halaman publik dan login |
| `app/Http/Controllers/Admin/` | Controller CRUD admin               |
| `app/Models/`                 | Model Dosen, Berita, MataKuliah     |
| `database/migrations/`        | Struktur tabel                      |
| `database/seeders/`           | Data contoh dan akun admin          |
| `resources/views/`            | Tampilan Blade (publik dan admin)   |

## REST API dan Node.js

Laravel menyediakan REST API berita (`/api/v1/...`) yang dilindungi token Sanctum.
Folder `node-api/` berisi backend Node.js kedua yang menerima webhook dari Laravel.

1. Tambahkan di `.env`:
   ```
   WEBHOOK_URL=http://127.0.0.1:3000/webhook/berita
   WEBHOOK_SECRET=rahasia-webhook-123
   ```
2. Jalankan Node.js:
   ```
   cd node-api
   npm install
   npm start
   ```
3. Login API: `POST /api/v1/login` dengan akun admin demo, lalu kirim token lewat header `Authorization: Bearer <token>`.
4. Halaman demo: login admin, lalu menu **Berita via API**.

## Pembuat

Nama: Zaldy Alamsyah Mokoginta
NIM: 2443055
Mata Kuliah: Pemrograman Berbasis Kerangka Kerja
