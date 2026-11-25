# Pondok Pesantren Nurul Ibad

Website profil dan penerimaan santri baru (PSB) **Pondok Pesantren Nurul Ibad**, Lubang Buaya, Cipayung, Jakarta Timur. Khusus santri putra, binaan terbatas ±25 santri.

Web ini hanya **tampilan** (landing page). Tidak ada login, admin, maupun database. Pendaftaran dan pertanyaan calon wali santri dikirim lewat **WhatsApp**.

## Isi halaman

- Profil & sanad keilmuan, serta empat karakter santri
- Lingkungan pondok (galeri foto dengan perbesar/lightbox)
- Program Bimbingan Multimedia & Komputer
- Dewan asatidz dan pimpinan yayasan
- Tim humas dengan tombol chat WhatsApp per ustadz
- Informasi infaq & pendaftaran, alur PSB 4 langkah
- Formulir pendaftaran awal yang diteruskan ke WhatsApp panitia
- Lokasi, peta, dan petunjuk arah

## Teknologi

- Laravel (Blade) untuk routing dan template
- Tailwind CSS (via CDN) untuk tampilan
- JavaScript biasa untuk menu HP, animasi scroll, galeri, dan formulir WhatsApp
- Google Fonts: Plus Jakarta Sans dan Amiri

> Tailwind masih memakai CDN, jadi halaman butuh koneksi internet saat dibuka. Untuk produksi, sebaiknya di-build lewat Vite (`npm run build`).

## Menjalankan di komputer

Kebutuhan: PHP 8.2 atau lebih baru dan Composer.

```bash
git clone https://github.com/ramaadhikusumah-glitch/Nurul-Ibad.git
cd Nurul-Ibad
composer install
```

Salin file pengaturan:

```bash
# Windows (PowerShell / CMD)
copy .env.example .env

# macOS / Linux
cp .env.example .env
```

Buat kunci aplikasi dan jalankan:

```bash
php artisan key:generate
php artisan serve
```

Buka `http://127.0.0.1:8000`.

Pastikan di `.env` memakai penyimpanan berbasis file, karena web ini tidak memakai database:

```env
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Tidak perlu menjalankan `php artisan migrate`.

## Mengubah isi web

Semua teks, nomor WhatsApp, alamat, dan daftar foto ada di satu file:

```
config/pesantren.php
```

Bagian yang paling sering diubah:

| Kunci | Isinya |
|---|---|
| `wa_panitia` | Nomor WhatsApp panitia PSB (format `62...`, tanpa `+` dan tanpa `0` di depan) |
| `alamat`, `jam_kunjungan`, `maps_*` | Alamat, jam kunjungan, dan tautan Google Maps |
| `hero`, `statistik` | Judul dan ringkasan di bagian atas |
| `galeri` | Foto lingkungan beserta captionnya |
| `profil`, `karakter` | Profil pondok dan empat karakter santri |
| `it` | Program bimbingan multimedia & komputer |
| `dewan` | Pimpinan yayasan dan asatidz |
| `humas` | Tim humas (nama, nomor, pesan WhatsApp otomatis) |
| `infaq`, `psb` | Informasi infaq, alur pendaftaran, pilihan tingkat |

Tampilan halaman ada di `resources/views/home.blade.php`.

Setelah mengubah config, jalankan `php artisan config:clear` bila perubahan belum terlihat.

## Foto dan logo

Simpan di `public/images/` dengan nama persis seperti di bawah (huruf kecil semua). Jika file belum ada, web otomatis menampilkan inisial atau kotak pengganti, jadi tidak ada gambar rusak.

| Isi | Lokasi file |
|---|---|
| Logo | `public/images/logo.png` (PNG, latar transparan) |
| Foto lingkungan (foto 1 jadi foto utama di bagian atas) | `public/images/lingkungan/1.jpg`, `2.jpg`, dst. |
| Pendiri | `public/images/tokoh/pendiri.jpg` |
| Ketua yayasan | `public/images/tokoh/ketua-yayasan.jpg` |
| Ustadz dan humas | `public/images/ustadz/bisrilhafi.jpg`, `rifki.jpg`, `mazen.jpg`, `taufiq.jpg` |

Saran: foto orang berbentuk kotak atau 3:4 dengan wajah di tengah, ukuran di bawah 300 KB (WebP atau JPG). Foto lingkungan berbentuk landscape, lebar sekitar 1600 px.

Untuk menambah ustadz atau foto galeri, cukup tambah satu baris di `config/pesantren.php` pada bagian `dewan` atau `galeri`.

## Pemasangan di hosting

- PHP 8.2 atau lebih baru dengan ekstensi standar Laravel
- Arahkan root domain ke folder `public/`
- Di `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL` sesuai domain
- Jalankan `composer install --no-dev --optimize-autoloader`
- Jangan unggah file `.env` dari komputer pengembang; buat `.env` baru di server lalu jalankan `php artisan key:generate`

## Catatan

- Foto dan data pimpinan, pengajar, serta santri hanya dipublikasikan atas izin pihak pondok.
- Isi web mengikuti situs sebelumnya; yang diperbarui adalah tampilannya.