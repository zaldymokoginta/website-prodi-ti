<?php

namespace App\Http\Controllers;

use App\Models\Dosen;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::orderBy('nama')->get();

        return view('dosen.index', compact('dosen'));
    }
}