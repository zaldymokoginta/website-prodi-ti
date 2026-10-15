<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Dosen;
use App\Models\MataKuliah;

class BerandaController extends Controller
{
    public function index()
    {
        
        $beritaTerbaru = Berita::whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        $dosen = Dosen::take(4)->get();
        $totalMatkul = MataKuliah::count();
        $kaprodi = Dosen::where('jabatan', 'like', '%Ketua Program Studi%')->first();

        return view('beranda', compact('beritaTerbaru', 'dosen', 'totalMatkul', 'kaprodi'));

    }
}