<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $dosen = [
            ['nama' => 'Dr. Budi Santoso, M.Kom.', 'nidn' => '0011018801', 'jabatan' => 'Ketua Program Studi', 'email' => 'budi@kampus.ac.id', 'bidang_keahlian' => 'Kecerdasan Buatan'],
            ['nama' => 'Siti Rahmawati, M.T.', 'nidn' => '0022029002', 'jabatan' => 'Sekretaris Program Studi', 'email' => 'siti@kampus.ac.id', 'bidang_keahlian' => 'Jaringan Komputer'],
            ['nama' => 'Andi Pratama, M.Cs.', 'nidn' => '0033039103', 'jabatan' => 'Dosen', 'email' => 'andi@kampus.ac.id', 'bidang_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama' => 'Dewi Lestari, M.Kom.', 'nidn' => '0044049204', 'jabatan' => 'Dosen', 'email' => 'dewi@kampus.ac.id', 'bidang_keahlian' => 'Basis Data'],
        ];
        foreach ($dosen as $d) {
            Dosen::create($d);
        }

        $matkul = [
            ['kode' => 'IF101', 'nama' => 'Algoritma dan Pemrograman', 'sks' => 3, 'semester' => 1],
            ['kode' => 'IF102', 'nama' => 'Matematika Diskrit', 'sks' => 3, 'semester' => 1],
            ['kode' => 'IF201', 'nama' => 'Struktur Data', 'sks' => 3, 'semester' => 2],
            ['kode' => 'IF301', 'nama' => 'Basis Data', 'sks' => 3, 'semester' => 3],
            ['kode' => 'IF401', 'nama' => 'Pemrograman Web', 'sks' => 3, 'semester' => 4],
        ];
        foreach ($matkul as $m) {
            MataKuliah::create($m);
        }

        $judulBerita = [
            'Penerimaan Mahasiswa Baru 2026 Dibuka',
            'Mahasiswa Informatika Juara Lomba Pemrograman',
            'Seminar Nasional Kecerdasan Buatan',
        ];
        foreach ($judulBerita as $i => $judul) {
            Berita::create([
                'judul' => $judul,
                'slug' => Str::slug($judul),
                'ringkasan' => 'Ringkasan singkat berita: ' . $judul . '.',
                'isi' => 'Ini adalah isi lengkap berita "' . $judul . '". Konten ini hanya contoh dan akan diganti dengan berita sebenarnya.',
                'published_at' => now()->subDays($i),
            ]);
        }
    }
}