<?php

namespace App\Services;

use App\Models\Berita;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookNotifier
{
    public static function kirim(string $event, Berita $berita): void
    {
        $url = config('services.prodi.webhook_url');

        if (! $url) {
            return;
        }

        try {
            Http::timeout(3)->post($url, [
                'event' => $event,
                'berita' => [
                    'id' => $berita->id,
                    'judul' => $berita->judul,
                    'status' => $berita->published_at ? 'terbit' : 'draft',
                ],
                'waktu' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Webhook gagal dikirim: ' . $e->getMessage());
        }
    }
}