<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;

class MataKuliahController extends Controller
{
    public function index()
    {
        $perSemester = MataKuliah::orderBy('semester')
            ->orderBy('kode')
            ->get()
            ->groupBy('semester');

        return view('matkul.index', compact('perSemester'));
    }
}