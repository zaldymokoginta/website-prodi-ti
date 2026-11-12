<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'ringkasan' => $this->ringkasan,
            'status' => $this->published_at ? 'terbit' : 'draft',
            'published_at' => $this->published_at?->toIso8601String(),
            'gambar_url' => $this->gambar ? asset('storage/' . $this->gambar) : null,
        ];
    }
}