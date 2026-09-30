<?php
require_once __DIR__ . '/helpers.php';

$siteName = 'KursusKu';
$tagline  = 'Belajar, daftar, dan kelola kursus dalam satu tempat.';
$courses  = require __DIR__ . '/data/courses.php';

$pageTitle = 'Beranda';
require __DIR__ . '/partials/header.php';
?>
<main>
  <section id="hero" class="hero">
    <div class="container">
      <p class="eyebrow">Kursus Teknologi</p>
      <h1><?= e($tagline) ?></h1>
      <p class="lead">Temukan kursus teknologi yang relevan untuk meningkatkan keterampilan Anda.</p>
      <div class="hero-actions">
        <a class="btn-primary" href="#katalog">Lihat Katalog Kursus</a>
        <a class="btn-outline" href="registration.php">Daftar Sekarang</a>
      </div>
    </div>
  </section>

  <div class="container">
    <section id="keunggulan" class="section">
      <h2>Mengapa Memilih KursusKu?</h2>
      <div class="card-grid">
        <article class="feature-card">
          <h3>Materi Terarah</h3>
          <p>Materi disusun bertahap dari dasar hingga praktik.</p>
        </article>
        <article class="feature-card">
          <h3>Belajar dengan Proyek</h3>
          <p>Setiap tahap menghasilkan hasil nyata.</p>
        </article>
        <article class="feature-card">
          <h3>Pendampingan Praktik</h3>
          <p>Peserta belajar melalui demonstrasi, latihan, dan evaluasi.</p>
        </article>
      </div>
    </section>

    <section id="katalog" class="section">
      <div class="section-head">
        <h2>Katalog Kursus</h2>
        <a class="btn-outline" href="fee-calculator.php">Lihat Estimasi Biaya</a>
      </div>
      <div class="table-wrap">
        <table class="data-table">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama Kursus</th>
              <th>Biaya</th>
              <th>Mulai</th>
              <th>Sisa Kursi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($courses as $course): ?>
              <?php
                $status      = statusKursus($course['quota'], $course['registered']);
                $statusClass = $status === 'Penuh' ? 'badge-full' : 'badge-available';
              ?>
              <tr>
                <td><?= e($course['code']) ?></td>
                <td><?= e($course['name']) ?></td>
                <td><?= rupiah($course['fee']) ?></td>
                <td><?= formatTanggal($course['start_date']) ?></td>
                <td><?= sisaKursi($course['quota'], $course['registered']) ?></td>
                <td><span class="<?= $statusClass ?>"><?= $status ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p><a class="btn-primary" href="registration.php">Daftar Kursus</a></p>
    </section>

    <section id="alur" class="section">
      <h2>Cara Mendaftar</h2>
      <ol class="steps">
        <li>Pilih kursus yang diminati.</li>
        <li>Isi form pendaftaran dengan benar.</li>
        <li>Periksa kembali data.</li>
        <li>Kirim pendaftaran dan tunggu konfirmasi admin.</li>
      </ol>
    </section>

    <section id="media" class="section">
      <h2>Kenali Program Kami</h2>
      <img class="media" src="assets/images/senam.jpg"
           alt="Peserta kegiatan mengenakan seragam merah bergerak bersama di ruang terbuka" width="640">
      <h3>Video Singkat</h3>
      <video class="media" controls width="640">
        <source src="assets/video/intro-kursus.mp4" type="video/mp4">
        Browser Anda tidak mendukung video HTML5.
      </video>
      <p><a href="https://www.php.net/" target="_blank" rel="noopener">Dokumentasi PHP</a></p>
    </section>

    <section id="kontak" class="section">
      <h2>Kontak</h2>
      <p>Email: kevinprayogaputra15@gmail.com</p>
      <p>Alamat: garegeh</p>
    </section>
  </div>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
