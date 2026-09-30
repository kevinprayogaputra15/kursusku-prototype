<?php
require_once __DIR__ . '/helpers.php';

$courses = require __DIR__ . '/data/courses.php';

// Pertemuan 5: kalkulator memakai GET karena hasilnya boleh di-bookmark/dibagikan.
$selectedCode     = $_GET['course'] ?? $courses[0]['code'];
$participantCount = max(1, min(10, (int) ($_GET['participants'] ?? 1)));

$course = cariKursus($courses, (string) $selectedCode) ?? $courses[0];

$discountPercent = 10;   // diskon 10% untuk pendaftaran berkelompok
$adminFee        = 50000;

$subtotal = $course['fee'] * $participantCount;
$discount = $participantCount >= 3 ? intdiv($subtotal * $discountPercent, 100) : 0;
$total    = $subtotal - $discount + $adminFee;

$siteName  = 'KursusKu';
$pageTitle = 'Estimasi Biaya';
require __DIR__ . '/partials/header.php';
?>
<main class="container">
  <section class="page-intro">
    <p class="eyebrow">Kalkulator</p>
    <h1>Estimasi Biaya Kursus</h1>
    <p>Pilih kursus dan jumlah peserta. Diskon <?= $discountPercent ?>% berlaku untuk 3 peserta atau lebih.</p>
  </section>

  <section class="form-card">
    <form action="fee-calculator.php" method="GET">
      <div class="form-grid">
        <div class="form-group">
          <label for="course">Kursus</label>
          <select id="course" name="course">
            <?php foreach ($courses as $item): ?>
              <option value="<?= e($item['code']) ?>" <?= $item['code'] === $course['code'] ? 'selected' : '' ?>>
                <?= e($item['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="participants">Jumlah Peserta (1-10)</label>
          <input id="participants" name="participants" type="number" min="1" max="10"
                 value="<?= $participantCount ?>">
        </div>
      </div>
      <button class="btn-primary" type="submit">Hitung Estimasi</button>
    </form>
  </section>

  <section class="summary-card">
    <h2>Rincian: <?= e($course['name']) ?></h2>
    <div class="table-wrap">
      <table class="data-table">
        <tr><th>Komponen</th><th>Nilai</th></tr>
        <tr><td>Biaya per peserta</td><td><?= rupiah($course['fee']) ?></td></tr>
        <tr><td>Jumlah peserta</td><td><?= $participantCount ?></td></tr>
        <tr><td>Subtotal</td><td><?= rupiah($subtotal) ?></td></tr>
        <tr><td>Diskon (<?= $discountPercent ?>%)</td><td>- <?= rupiah($discount) ?></td></tr>
        <tr><td>Biaya admin</td><td><?= rupiah($adminFee) ?></td></tr>
        <tr class="total"><td>Total akhir</td><td><?= rupiah($total) ?></td></tr>
      </table>
    </div>
    <p><a class="btn-primary" href="registration.php">Lanjut Daftar</a>
       <a class="btn-outline" href="index.php#katalog">Kembali ke Katalog</a></p>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
