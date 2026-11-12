const express = require('express');
const cors = require('cors');

const PORT = process.env.PORT || 3000;
const API_KEY = process.env.API_KEY || 'prodi-demo-key-123';
const WEBHOOK_SECRET = process.env.WEBHOOK_SECRET || 'rahasia-webhook-123';
const LARAVEL_URL = process.env.LARAVEL_URL || 'http://127.0.0.1:8000';

const app = express();
app.use(cors());
app.use(express.json());

// "Database" sementara di memori. Hilang saat server dimatikan.
const beritaStore = new Map(); // id -> data berita
const notifikasi = [];         // daftar webhook yang diterima
let nomorNotifikasi = 0;

// Penjaga: hanya permintaan dengan API key yang benar yang lolos
function apiKey(req, res, next) {
  if (req.get('X-API-Key') !== API_KEY) {
    return res.status(401).json({ message: 'API key tidak valid.' });
  }
  next();
}

// GET /api/v1/statistik  (JSON sama persis dengan Laravel)
app.get('/api/v1/statistik', apiKey, (req, res) => {
  const semua = beritaStore.size;
  const terbit = [...beritaStore.values()].filter((b) => b.status === 'terbit').length;

  res.json({ data: { semua, terbit, draft: semua - terbit } });
});

// GET /api/v1/berita?status=terbit|draft
app.get('/api/v1/berita', apiKey, (req, res) => {
  const { status } = req.query;

  if (status && !['draft', 'terbit'].includes(status)) {
    return res.status(422).json({
      message: 'Status tidak valid.',
      errors: { status: ['Status harus draft atau terbit.'] },
    });
  }

  let data = [...beritaStore.values()].sort((a, b) => b.id - a.id);
  if (status) {
    data = data.filter((b) => b.status === status);
  }

  res.json({ data });
});

// POST /webhook/berita  (dipanggil oleh Laravel)
app.post('/webhook/berita', (req, res) => {
  if (req.get('X-Webhook-Secret') !== WEBHOOK_SECRET) {
    return res.status(401).json({ message: 'Secret webhook tidak valid.' });
  }

  const { event, berita, waktu } = req.body || {};

  if (!event || !berita || berita.id === undefined) {
    return res.status(422).json({ message: 'Payload webhook tidak valid.' });
  }

  beritaStore.set(berita.id, berita);

  notifikasi.unshift({
    id: ++nomorNotifikasi,
    event,
    judul: berita.judul,
    status: berita.status,
    waktu,
    diterima: new Date().toISOString(),
  });
  if (notifikasi.length > 100) notifikasi.pop();

  console.log(`[webhook] ${event}: ${berita.judul} (${berita.status})`);
  res.status(200).json({ message: 'Webhook diterima.' });
});

// GET /api/v1/notifikasi
app.get('/api/v1/notifikasi', apiKey, (req, res) => {
  res.json({ data: notifikasi });
});

// Alamat yang tidak dikenal
app.use((req, res) => {
  res.status(404).json({ message: 'Endpoint tidak ditemukan.' });
});

// Saat menyala, ambil data berita yang sudah ada dari Laravel
async function sinkronAwal() {
  try {
    const res = await fetch(`${LARAVEL_URL}/api/v1/berita`, {
      headers: { Accept: 'application/json', 'X-API-Key': API_KEY },
    });
    if (!res.ok) throw new Error('status ' + res.status);

    const json = await res.json();
    json.data.forEach((b) => beritaStore.set(b.id, b));
    console.log(`Sinkron awal: ${json.data.length} berita dari Laravel.`);
  } catch (e) {
    console.log('Sinkron awal dilewati (Laravel belum jalan?):', e.message);
  }
}

app.listen(PORT, () => {
  console.log(`Server Node.js berjalan di http://127.0.0.1:${PORT}`);
  sinkronAwal();
});