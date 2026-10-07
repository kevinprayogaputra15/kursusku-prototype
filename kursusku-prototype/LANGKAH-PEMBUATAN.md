# KursusKu Prototype - Langkah Pembuatan (Pertemuan 2 s.d. 6)

Satu proyek yang berkembang tiap minggu. Jalankan lewat Laragon: `C:\laragon\www\kursusku-prototype`, buka `http://kursusku-prototype.test/` (jangan lewat `file:///`).

> **Sebelum menimpa file lama:** simpan versi Pertemuan 5 di Git, supaya riwayat tugas tidak hilang.
> ```
> git add -A && git commit -m "week-05: form POST + css" && git tag week-05
> ```

## Struktur akhir (Pertemuan 6)

```
kursusku-prototype/
├── index.php                  Landing + katalog + fasilitas (P2, P4, P6)
├── register.php               Form pendaftaran lanjutan (P5 -> P6)
├── process.php                Validasi, diskon, ringkasan (P6)
├── fee-calculator.php         Estimasi biaya, form GET (P3 -> P6)
├── history.php                Data dummy + foreach (P6)
├── loop-lab.php               Latihan for / while / do-while / if / switch (P6)
├── data.php                   SATU sumber data: courses, interestOptions, facilities, dll.
├── helpers.php                e, formatRupiah, findCourse, getDiscountPercent, getLearningModeLabel, hitungBiaya, postString ...
├── partials/header.php, footer.php
├── assets/css/style.css  assets/images/  assets/video/
├── evidence/week-05/  evidence/week-06/   Template evidence (screenshot Anda isi sendiri)
├── evidence-1/                Evidence minggu 1-4 milik Anda (tidak diubah)
└── legacy/                    hello.php, server-time.php, test-function.php
```

## Perubahan penting dari Pertemuan 5

| Perubahan | Alasan |
|---|---|
| `registration.php` + `process-registration.php` menjadi `register.php` + `process.php` | Nama file mengikuti panduan P6 |
| `data/courses.php` digabung ke `data.php` | Panduan P6 meminta `data.php`; satu sumber data |
| `rupiah()` menjadi `formatRupiah()`, `cariKursus()` menjadi `findCourse()` | Nama fungsi mengikuti panduan; format `Rp240.000` (tanpa spasi) |
| Harga kursus disesuaikan: Web 300.000, PHP 400.000, Laravel 500.000 | Agar test matrix P6 (mis. Rp240.000, Rp340.000) bisa lulus |
| "Laravel Fundamental" menjadi "Laravel Dasar", terisi 20/25 (tidak lagi penuh) | Test #3 butuh Laravel bisa dipilih. Contoh status **Penuh** kini PHP Lanjutan (25/25) |
| Kalkulator memakai aturan P6 (diskon per tipe peserta, 1-3 paket); biaya admin dan diskon kelompok P3 dihapus | Satu aturan bisnis yang sama dengan `process.php` |
| Form P5 (HP, prodi, hidden `source`) dipertahankan, ditambah field P6 | Kesinambungan proyek |

Jika dosen memakai data persis seperti panduan (3 kursus saja), ganti isi `$courses` di `data.php`; semua halaman ikut menyesuaikan.

---

## Pertemuan 2 - Landing page HTML
1. Buat `index.php`: `<header>`, `<nav>`, `<main>`, `<footer>`.
2. Section: `hero`, `keunggulan`, `katalog`, `alur` (list bernomor), `media` (gambar + video), `kontak`.
3. Gambar wajib `alt`; video pakai `controls`; link luar pakai `target="_blank" rel="noopener"`.
4. Checkpoint: semua link anchor (`#katalog`, dst.) berpindah ke bagian yang benar.

## Pertemuan 3 - Variabel, operator, kalkulator biaya
1. Variabel `$siteName`, `$tagline`, tampilkan dengan `<?= ... ?>`.
2. `fee-calculator.php`: subtotal = biaya x jumlah; diskon = `intdiv(subtotal x persen, 100)`; total = subtotal - diskon.
3. Format angka dengan `number_format()` (kini dibungkus `formatRupiah()`).

## Pertemuan 4 - Array, fungsi, katalog
1. Data kursus dalam array asosiatif (`code, name, fee, quota, registered, start_date`) di `data.php`.
2. Fungsi di `helpers.php`: `formatRupiah`, `statusKursus`, `sisaKursi`, `formatTanggal`.
3. `index.php`: `foreach ($courses as $course)` membuat baris tabel.
4. Checkpoint: PHP Lanjutan 25/25 berstatus **Penuh**; MySQL Dasar 0/20 sisa 20.

## Pertemuan 5 - Form, CSS, GET/POST, hosting
1. CSS global di `assets/css/style.css` (variabel `:root`, `.container`, `.form-grid`, `:focus`, media query 640 px).
2. Form: label `for` = `id`; `name` = key `$_POST`; hidden, text, email, tel, select, radio, checkbox `[]`, textarea, button.
3. Eksperimen GET: ubah `method="GET"` sementara, screenshot URL, **kembalikan ke POST**.
4. Hosting: tabel local vs production di `evidence/week-05/local-vs-hosting.txt`.

## Pertemuan 6 - Percabangan, looping, form lanjutan

### A. Data dan helper
1. `data.php`: `$courses`, `$interestOptions`, `$participantTypes`, `$learningModes`, `$facilities`.
2. `helpers.php`: tambah `findCourse()` (foreach), `getDiscountPercent()` (if/elseif), `getLearningModeLabel()` (switch), `hitungBiaya()`, `postString()`.
   Ketik dan jalankan satu fungsi per langkah.

### B. Form `register.php` (semua opsi dibuat dengan loop)
- `<select>` kursus: `foreach ($courses ...)`; kursus penuh diberi `disabled`.
- Radio tipe peserta: satu `name="participant_type"` agar hanya satu nilai terkirim; `required` cukup pada satu radio.
- Checkbox minat: `name="interests[]"`, dibuat dari `$interestOptions`.
- Select metode belajar dan jumlah paket: `for ($i = 1; $i <= 3; $i++)`.
- Textarea `notes`, `maxlength="300"`.

### C. Pemrosesan `process.php` (urutan wajib)
1. Jika bukan POST: `header('Location: register.php'); exit;` (sebelum output HTML apa pun).
2. Baca input dengan default aman (`?? ''`, `postString()`); checkbox: pastikan array lalu `array_intersect` dengan opsi sah.
3. Validasi ke array `$errors` (nama, email, HP, prodi, kursus, tipe, metode, paket).
4. Ada error: tampilkan dengan `foreach`, lalu `exit` agar perhitungan tidak jalan.
5. Hitung: biaya satuan -> x paket = subtotal -> % diskon -> nilai diskon -> total akhir.
6. Tampilkan ringkasan; semua teks pengguna lewat `e()`.

Tabel uji manual: PHP Dasar / Mahasiswa / 1 paket = Rp320.000; Guru = Rp340.000; Umum = Rp400.000 (dengan harga PHP Dasar Rp400.000 di `data.php`).

### D. `history.php` dan `loop-lab.php`
- `history.php`: array dummy + `foreach ($history as $index => $item)`; ini bukan CRUD.
- `loop-lab.php`: `for`, `while`, `do-while` dengan satu variabel `$limit`. Latihan: ubah 5 menjadi 3 dan jelaskan bagian mana yang menghentikan loop.

### E. Integrasi dan pengujian
1. Navigasi: Beranda, Katalog, Estimasi Biaya, History Dummy, Daftar Kursus (semua halaman lewat `partials/header.php`).
2. Jalankan 12 test di `evidence/week-06/test-matrix.txt`; jika FAIL, cari penyebab di input/branching/loop/type conversion, perbaiki, ulang test itu.
3. Ambil 6 screenshot (`CHECKLIST-SCREENSHOT.txt`), isi refleksi dan AI usage log.

## Checklist akhir P6
- [ ] Form POST ke `process.php`; radio, checkbox `[]`, select, textarea berfungsi
- [ ] Kursus dan minat dirender dari array, bukan ditulis manual
- [ ] Diskon benar untuk mahasiswa/guru/umum; `switch` dipakai untuk label metode
- [ ] Minat kosong tidak menimbulkan warning
- [ ] 12 test PASS/FAIL terisi hasil Anda; 6 screenshot tersimpan
- [ ] Anda dapat menjelaskan satu branching dan satu looping di kode sendiri tanpa membaca

Belum diwajibkan: database, CRUD, login, Laravel (mulai Pertemuan 7).
