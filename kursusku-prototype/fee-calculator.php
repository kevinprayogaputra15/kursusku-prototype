<?php
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Aturan sama dengan process.php (helper dipakai ulang). GET dipilih agar hasil bisa di-bookmark.
$courseCode      = (string) ($_GET['course'] ?? $courses[0]['code']);
$participantType = (string) ($_GET['type'] ?? 'umum');
$packageCount    = max(1, min(3, (int) ($_GET['packages'] ?? 1)));

$course = findCourse($courses, $courseCode) ?? $courses[0];
if (!array_key_exists($participantType, $participantTypes)) {
    $participantType = 'umum';
}

$discountPercent = getDiscountPercent($participantType);
$cost            = hitungBiaya($course['fee'], $packageCount, $discountPercent);

$siteName  = 'KursusKu';
$pageTitle = 'Estimasi Biaya';
require __DIR__ . '/partials/header.php';
?>
<main class="container">
  <section class="page-intro">
    <p class="eyebrow">Kalkulator</p>
    <h1>Estimasi Biaya Kursus</h1>
    <p>Diskon mengikuti tipe peserta: Mahasiswa 20%, Guru 15%, Umum 0%.</p>
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
          <label for="type">Tipe Peserta</label>
          <select id="type" name="type">
            <?php foreach ($participantTypes as $value => $label): ?>
              <option value="<?= e($value) ?>" <?= $value === $participantType ? 'selected' : '' ?>><?= e($label) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="packages">Jumlah Paket</label>
          <select id="packages" name="packages">
            <?php for ($i = 1; $i <= 3; $i++): ?>
              <option value="<?= $i ?>" <?= $i === $packageCount ? 'selected' : '' ?>><?= $i ?> paket</option>
            <?php endfor; ?>
          </select>
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
        <tr><td>Biaya per paket</td><td><?= formatRupiah($course['fee']) ?></td></tr>
        <tr><td>Jumlah paket</td><td><?= $packageCount ?></td></tr>
        <tr><td>Subtotal</td><td><?= formatRupiah($cost['gross']) ?></td></tr>
        <tr><td>Diskon (<?= $discountPercent ?>%)</td><td>-<?= formatRupiah($cost['discount']) ?></td></tr>
        <tr class="total"><td>Total akhir</td><td><?= formatRupiah($cost['total']) ?></td></tr>
      </table>
    </div>
    <p>
      <a class="btn-primary" href="register.php">Lanjut Daftar</a>
      <a class="btn-outline" href="index.php#katalog">Kembali ke Katalog</a>
    </p>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
