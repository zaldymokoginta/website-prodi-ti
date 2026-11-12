const express = require('express');
const cors = require('cors');

const PORT = process.env.PORT || 3000;
const WEBHOOK_SECRET = process.env.WEBHOOK_SECRET || 'rahasia-webhook-123';
const LARAVEL_URL = process.env.LARAVEL_URL || 'http://127.0.0.1:8000';
const MASA_CACHE = 10000; // hasil verifikasi token diingat 10 detik

const app = express();
app.use(cors());
app.use(express.json());

// "Database" sementara di memori. Hilang saat server dimatikan.
const beritaStore = new Map();
const notifikasi = [];
let nomorNotifikasi = 0;
let sudahSinkron = false;
const cacheToken = new Map();

// Tanya Laravel: token ini milik siapa? (null jika tidak valid)
async function verifikasi(auth) {
  const cache = cacheToken.get(auth);
  if (cache && cache.exp > Date.now()) return cache.user;

  const res = await fetch(`${LARAVEL_URL}/api/v1/me`, {
    headers: { Accept: 'application/json', Authorization: auth },
  });

  if (res.status === 401) {
    cacheToken.delete(auth);
    return null;
  }
  if (!res.ok) throw new Error('Laravel menjawab ' + res.status);

  const user = (await res.json()).data;
  cacheToken.set(auth, { user, exp: Date.now() + MASA_CACHE });
  return user;
}

// Ambil data berita yang sudah ada di Laravel (sekali saja)
async function sinkronAwal(auth) {
  if (sudahSinkron) return;

  try {
    const res = await fetch(`${LARAVEL_URL}/api/v1/berita`, {
      headers: { Accept: 'application/json', Authorization: auth },
    });
    if (!res.ok) throw new Error('status ' + res.status);

    const json = await res.json();
    json.data.forEach((b) => {
      if (!beritaStore.has(b.id)) beritaStore.set(b.id, b);
    });
    sudahSinkron = true;
    console.log(`Sinkron awal: ${json.data.length} berita dari Laravel.`);
  } catch (e) {
    console.log('Sinkron awal ditunda:', e.message);
  }
}

// Penjaga: wajib header Authorization: Bearer <token>
async function bearer(req, res, next) {
  const auth = req.get('Authorization') || '';

  if (!auth.startsWith('Bearer ')) {
    return res.status(401).json({ message: 'Token tidak ditemukan.' });
  }

  try {
    const user = await verifikasi(auth);
    if (!user) {
      return res.status(401).json({ message: 'Token tidak valid.' });
    }
    req.user = user;
  } catch (e) {
    return res.status(502).json({ message: 'Tidak dapat memverifikasi token ke Laravel.' });
  }

  await sinkronAwal(auth);
  next();
}

// GET /api/v1/statistik  (JSON sama persis dengan Laravel)
app.get('/api/v1/statistik', bearer, (req, res) => {
  const semua = beritaStore.size;
  const terbit = [...beritaStore.values()].filter((b) => b.status === 'terbit').length;

  res.json({ data: { semua, terbit, draft: semua - terbit } });
});

// GET /api/v1/berita?status=terbit|draft
app.get('/api/v1/berita', bearer, (req, res) => {
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

// POST /webhook/berita  (dipanggil Laravel, dijaga secret, bukan token)
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
app.get('/api/v1/notifikasi', bearer, (req, res) => {
  res.json({ data: notifikasi });
});

app.use((req, res) => {
  res.status(404).json({ message: 'Endpoint tidak ditemukan.' });
});

app.listen(PORT, () => {
  console.log(`Server Node.js berjalan di http://127.0.0.1:${PORT}`);
});