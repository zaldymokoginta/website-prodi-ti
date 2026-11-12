<?php

namespace App\Services;

use App\Http\Resources\BeritaResource;
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
            Http::timeout(3)
                ->withHeaders(['X-Webhook-Secret' => (string) config('services.prodi.webhook_secret')])
                ->post($url, [
                    'event' => $event,
                    'berita' => (new BeritaResource($berita))->resolve(),
                    'waktu' => now()->toIso8601String(),
                ]);
        } catch (\Throwable $e) {
            Log::warning('Webhook gagal dikirim: ' . $e->getMessage());
        }
    }
}