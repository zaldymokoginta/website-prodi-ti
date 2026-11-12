<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use App\Models\Berita;
use App\Services\WebhookNotifier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BeritaController extends Controller
{
    // GET /api/v1/berita?status=terbit|draft
    public function index(Request $request)
    {
        $request->validate([
            'status' => ['nullable', Rule::in(['draft', 'terbit'])],
        ]);

        $query = Berita::latest();

        if ($request->status === 'terbit') {
            $query->whereNotNull('published_at');
        } elseif ($request->status === 'draft') {
            $query->whereNull('published_at');
        }

        return BeritaResource::collection($query->get());
    }

    // GET /api/v1/berita/{id}
    public function show(Berita $berita)
    {
        return new BeritaResource($berita);
    }

    // POST /api/v1/berita
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'isi' => ['required', 'string'],
            'status' => ['nullable', Rule::in(['draft', 'terbit'])],
        ]);

        $terbit = ($data['status'] ?? 'draft') === 'terbit';

        $berita = Berita::create([
            'judul' => $data['judul'],
            'slug' => Berita::buatSlug($data['judul']),
            'ringkasan' => $data['ringkasan'],
            'isi' => $data['isi'],
            'published_at' => $terbit ? now() : null,
        ]);

        WebhookNotifier::kirim('berita.dibuat', $berita);

        return (new BeritaResource($berita))->response()->setStatusCode(201);
    }

    // PATCH /api/v1/berita/{id}/status
    public function ubahStatus(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['draft', 'terbit'])],
        ]);

        if ($data['status'] === 'draft' && $berita->published_at !== null) {
            throw ValidationException::withMessages([
                'status' => 'Berita yang sudah terbit tidak boleh dikembalikan menjadi draft.',
            ]);
        }

        if ($data['status'] === 'terbit' && $berita->published_at === null) {
            $berita->update(['published_at' => now()]);
            WebhookNotifier::kirim('berita.terbit', $berita);
        }

        return new BeritaResource($berita->fresh());
    }

    // GET /api/v1/statistik
    public function statistik()
    {
        $semua = Berita::count();
        $terbit = Berita::whereNotNull('published_at')->count();

        return response()->json([
            'data' => [
                'semua' => $semua,
                'terbit' => $terbit,
                'draft' => $semua - $terbit,
            ],
        ]);
    }
}