<?php
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Akses langsung lewat GET dikembalikan ke form. Redirect harus sebelum output HTML apa pun.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

// 1. Baca data POST (?? / helper memberi default agar tidak ada warning)
$name            = postString('name');
$email           = postString('email');
$phone           = postString('phone');
$studyProgram    = postString('study_program');
$courseCode      = postString('course_code');
$participantType = postString('participant_type');
$learningMode    = postString('learning_mode');
$packageCount    = (int) postString('package_count');
$notes           = postString('notes');
$source          = postString('source');

$interests = $_POST['interests'] ?? [];
if (!is_array($interests)) {
    $interests = [];
}
$interests = array_filter($interests, 'is_string');
$interests = array_values(array_intersect($interests, array_keys($interestOptions)));

// 2. Validasi fundamental
$errors = [];
if ($name === '') {
    $errors[] = 'Nama wajib diisi.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Format email tidak valid.';
}
if ($phone === '') {
    $errors[] = 'Nomor HP wajib diisi.';
}
if ($studyProgram === '') {
    $errors[] = 'Program studi / instansi wajib diisi.';
}
$course = findCourse($courses, $courseCode);
if ($course === null) {
    $errors[] = 'Kursus tidak ditemukan.';
} elseif (statusKursus($course['quota'], $course['registered']) === 'Penuh') {
    $errors[] = 'Kursus yang dipilih sudah penuh.';
}
if (!array_key_exists($participantType, $participantTypes)) {
    $errors[] = 'Tipe peserta tidak valid.';
}
if (!in_array($learningMode, $learningModes, true)) {
    $errors[] = 'Metode belajar tidak valid.';
}
if (!in_array($packageCount, [1, 2, 3], true)) {
    $errors[] = 'Jumlah paket tidak valid.';
}

// 3. Ada error -> tampilkan dan hentikan proses
if ($errors !== []) {
    $pageTitle = 'Data Belum Valid';
    require __DIR__ . '/partials/header.php';
    ?>
    <main class="container result-page">
      <section class="alert-error">
        <h1>Data belum dapat diproses</h1>
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= e($error) ?></li>
          <?php endforeach; ?>
        </ul>
        <a class="btn-primary" href="register.php">Kembali ke form</a>
      </section>
    </main>
    <?php
    require __DIR__ . '/partials/footer.php';
    exit;
}

// 4. Hitung biaya: biaya satuan -> jumlah paket -> subtotal -> % diskon -> nilai diskon -> total
$discountPercent   = getDiscountPercent($participantType);
$cost              = hitungBiaya($course['fee'], $packageCount, $discountPercent);
$learningModeLabel = getLearningModeLabel($learningMode);

$pageTitle = 'Ringkasan Pendaftaran';
require __DIR__ . '/partials/header.php';
?>
<main class="container result-page">
  <section class="alert-success">
    <h1>Pendaftaran Berhasil Diproses</h1>
    <p>Periksa kembali data latihan berikut.</p>
  </section>

  <section class="summary-card">
    <h2>Data Peserta</h2>
    <dl class="summary-list">
      <dt>Nama</dt><dd><?= e($name) ?></dd>
      <dt>Email</dt><dd><?= e($email) ?></dd>
      <dt>Nomor HP</dt><dd><?= e($phone) ?></dd>
      <dt>Prodi / Instansi</dt><dd><?= e($studyProgram) ?></dd>
      <dt>Kursus</dt><dd><?= e($course['name']) ?></dd>
      <dt>Tipe peserta</dt><dd><?= e($participantTypes[$participantType]) ?></dd>
      <dt>Metode</dt><dd><?= e($learningModeLabel) ?></dd>
      <dt>Jumlah paket</dt><dd><?= $packageCount ?></dd>
      <dt>Catatan</dt><dd><?= $notes === '' ? '-' : nl2br(e($notes)) ?></dd>
      <dt>Sumber form</dt><dd><?= e($source) ?></dd>
    </dl>

    <h2>Rincian Biaya</h2>
    <div class="table-wrap">
      <table class="data-table">
        <tr><td>Biaya per paket</td><td><?= formatRupiah($course['fee']) ?></td></tr>
        <tr><td>Subtotal (<?= $packageCount ?> paket)</td><td><?= formatRupiah($cost['gross']) ?></td></tr>
        <tr><td>Diskon <?= $discountPercent ?>%</td><td>-<?= formatRupiah($cost['discount']) ?></td></tr>
        <tr class="total"><td>Total akhir</td><td><?= formatRupiah($cost['total']) ?></td></tr>
      </table>
    </div>

    <h2>Minat</h2>
    <ul class="check-list">
      <?php if ($interests === []): ?>
        <li>Belum memilih minat.</li>
      <?php else: ?>
        <?php foreach ($interests as $interest): ?>
          <li><?= e($interestOptions[$interest] ?? $interest) ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>

    <p>
      <a class="btn-primary" href="register.php">Daftar Lagi</a>
      <a class="btn-outline" href="history.php">Lihat History Dummy</a>
    </p>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
