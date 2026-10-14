<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(6);

        return view('berita.index', compact('berita'));
    }

    public function show(Berita $berita)
    {
        abort_if($berita->published_at === null, 404);

        return view('berita.show', compact('berita'));
    }
}