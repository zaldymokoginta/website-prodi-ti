<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Dosen;
use App\Models\MataKuliah;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalDosen' => Dosen::count(),
            'totalBerita' => Berita::count(),
            'totalMatkul' => MataKuliah::count(),
        ]);
    }
}