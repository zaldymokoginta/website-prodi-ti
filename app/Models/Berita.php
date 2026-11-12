<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul', 'slug', 'ringkasan', 'isi', 'gambar', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public static function buatSlug(string $judul): string
{
    $asli = Str::slug($judul);
    $slug = $asli;
    $i = 2;

    while (static::where('slug', $slug)->exists()) {
        $slug = $asli . '-' . $i++;
    }

    return $slug;
}
}
