# KursusKu Prototype - Langkah Pembuatan (Pertemuan 2 s.d. 5)

Proyek tunggal yang berkembang tiap minggu. Jalankan lewat Laragon: `C:\laragon\www\kursusku-prototype` → buka `http://kursusku-prototype.test/` (jangan lewat `file:///`).

## Struktur akhir

```
kursusku-prototype/
├── index.php                  Beranda + katalog (P2, P4)
├── registration.php           Form pendaftaran (P5)
├── process-registration.php   Penerima data POST (P5)
├── fee-calculator.php         Estimasi biaya, form GET (P3, P5)
├── helpers.php                Fungsi bantu: rupiah, statusKursus, sisaKursi, formatTanggal, e, cariKursus
├── data/courses.php           Array katalog kursus (satu sumber data)
├── partials/header.php        Navigasi + <head> bersama
├── partials/footer.php
├── assets/css/style.css       CSS global, responsif (P5)
├── assets/images/  assets/video/
├── evidence/week-05/          Test matrix, local-vs-hosting, screenshot
├── evidence-1/                Evidence minggu 1-4 milik Anda (tidak diubah)
└── legacy/                    hello.php, server-time.php, test-function.php (latihan lama)
```

## Yang diperbaiki dari versi sebelumnya

| Masalah lama | Perbaikan |
|---|---|
| Folder `essets` tetapi kode memanggil `aseets` → gambar/video tidak muncul | Folder jadi `assets`, path di kode disamakan |
| `index.php` punya dua `<head>` dan variabel ganda; CSS tidak terpasang | Satu `<head>` lewat `partials/header.php` |
| `hero-kursus.jpg` tidak ada | Memakai `senam.jpg` yang ada di proyek |
| `style.css` di root, kalkulator pakai `<style>` sendiri | Satu `assets/css/style.css` untuk semua halaman |
| `fee-calculator.php` memakai harga tetap 2.500.000 (beda dengan katalog) | Harga diambil dari `data/courses.php` |
| `helpers.php` dan `test-function.php` mendefinisikan fungsi yang sama | Versi terbaik digabung ke `helpers.php`; file lama ke `legacy/` |
| Warna badge `#0ceb10` di atas hijau muda sulit dibaca | Warna kontras lebih tinggi |

---

## Pertemuan 2 - Landing page HTML

1. Buat `index.php` dengan `<header>`, `<nav>`, `<main>`, `<footer>`.
2. Isi section: `hero`, `keunggulan`, `katalog`, `alur` (daftar bernomor), `media` (gambar + video), `kontak`.
3. Beri `alt` pada gambar dan `controls` pada video; link eksternal memakai `target="_blank" rel="noopener"`.
4. Checkpoint: semua link anchor (`#katalog`, dst.) berpindah ke bagian yang benar.

## Pertemuan 3 - Variabel, operator, kalkulator biaya

1. Buat variabel `$siteName`, `$tagline`, `$year` dan tampilkan dengan `<?= ... ?>`.
2. Buat `fee-calculator.php`: `subtotal = biaya × peserta`, `diskon = intdiv(subtotal × persen, 100)`, `total = subtotal − diskon + admin`.
3. Format angka dengan `number_format()` (kini lewat `rupiah()`).
4. Checkpoint: 3 peserta Laravel Fundamental → subtotal 1.050.000, diskon 105.000, total 995.000.

## Pertemuan 4 - Array, fungsi, katalog

1. Pindahkan katalog ke array asosiatif di `data/courses.php` (`code, name, fee, quota, registered, start_date`).
2. Buat `helpers.php`: `rupiah()`, `statusKursus()`, `sisaKursi()`, `formatTanggal()`.
3. Di `index.php`: `$courses = require 'data/courses.php';` lalu `foreach` untuk membuat baris tabel.
4. Checkpoint: Laravel Fundamental (25/25) berstatus **Penuh**, sisa kursi 0; MySQL Dasar 0/20 → sisa 20.

## Pertemuan 5 - Form, CSS, GET/POST, hosting

### A. Struktur & navigasi
1. Buat `assets/css/style.css`, `registration.php`, `process-registration.php`, `evidence/week-05/`.
2. Navigasi: Beranda → Katalog → Daftar (ada di `partials/header.php`, dipakai semua halaman).

### B. Form (`registration.php`)
Sembilan kontrol: text (nama, prodi), email, tel, select, radio, checkbox, textarea, hidden, button.

Aturan yang harus Anda pahami:
- `label for="x"` terhubung ke `id="x"` → klik label memfokuskan input.
- `name` adalah key di `$_POST`; `id` hanya untuk label/CSS/JS.
- Checkbox jamak memakai `name="interests[]"` agar PHP menerima array.
- `required`, `type="email"`, `minlength`, `maxlength` hanya membantu pengguna; server tetap harus memvalidasi (Pertemuan 6).
- Opsi kursus dibuat dari katalog; kursus penuh diberi `disabled`.

### C. Eksperimen GET vs POST
1. Ubah `method="POST"` menjadi `GET`, submit dengan data latihan.
2. Address bar berisi `process-registration.php?source=week-05&name=...` → screenshot `04-get-url.png`. (Catatan: `$_POST` akan kosong saat GET; itu bagian dari pengamatan.)
3. Kembalikan ke `POST`. **Jangan tinggalkan GET.**
4. Kalkulator `fee-calculator.php` sengaja memakai GET karena hasilnya layak di-bookmark.

### D. Menerima data (`process-registration.php`)
`trim($_POST['name'] ?? '')` → ambil + rapikan; `implode()` menggabung checkbox; `e()` mengescape setiap output (uji dengan nama `<b>X</b>`, harus tampil sebagai teks).

### E. CSS responsif
Variabel `:root`, `.container`, `.form-grid` (2 kolom → 1 kolom di ≤640 px), state `:focus`, tabel dibungkus `.table-wrap` (scroll horizontal hanya di dalam tabel).

### F. Hosting
Isi `evidence/week-05/local-vs-hosting.txt` dengan kata-kata Anda: URL, database, environment, HTTPS, debug, secret, document root. POST tidak otomatis aman; HTTPS yang melindungi data saat transit.

### G. Pengujian & evidence
Isi `test-matrix.txt` (12 test) dan ambil 5 screenshot sesuai `CHECKLIST-SCREENSHOT.txt`.

## Checklist akhir
- [ ] Semua halaman terbuka tanpa error lewat Laragon
- [ ] Form: label lengkap, ≥6 jenis kontrol, method akhir POST
- [ ] Hasil POST tampil benar dan ter-escape
- [ ] 360 px tanpa horizontal scroll
- [ ] Evidence week-05 lengkap (screenshot milik Anda sendiri)
- [ ] Anda bisa menjelaskan `name` vs `id`, GET vs POST, local vs hosting tanpa membaca

## Belum diwajibkan (jangan ditambahkan dulu)
Database/CRUD, login, Laravel, Ajax, hosting publik, validasi server dengan percabangan (Pertemuan 6).
