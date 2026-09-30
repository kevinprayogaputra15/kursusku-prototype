<?php
require_once __DIR__ . '/helpers.php';

$courses = require __DIR__ . '/data/courses.php';

// Membaca data POST. "?? ''" memberi nilai default jika key tidak ada.
$name           = trim($_POST['name'] ?? '');
$email          = trim($_POST['email'] ?? '');
$phone          = trim($_POST['phone'] ?? '');
$studyProgram   = trim($_POST['study_program'] ?? '');
$courseCode     = $_POST['course'] ?? '';
$participantType = $_POST['participant_type'] ?? '';
$interests      = $_POST['interests'] ?? [];
$note           = trim($_POST['note'] ?? '');
$source         = $_POST['source'] ?? '';

$interestText = implode(', ', (array) $interests);
$course       = cariKursus($courses, (string) $courseCode);
$courseText   = $course ? $course['name'] . ' (' . rupiah($course['fee']) . ')' : $courseCode;

$siteName  = 'KursusKu';
$pageTitle = 'Hasil Pendaftaran';
require __DIR__ . '/partials/header.php';
?>
<main class="container result-page">
  <section class="alert-success">
    <h1>Pendaftaran Diterima untuk Diproses</h1>
    <p>Periksa kembali data latihan berikut.</p>
  </section>

  <section class="summary-card">
    <dl class="summary-list">
      <dt>Nama</dt><dd><?= e($name) ?></dd>
      <dt>Email</dt><dd><?= e($email) ?></dd>
      <dt>Nomor HP</dt><dd><?= e($phone) ?></dd>
      <dt>Program Studi</dt><dd><?= e($studyProgram) ?></dd>
      <dt>Kursus</dt><dd><?= e($courseText) ?></dd>
      <dt>Jenis Peserta</dt><dd><?= e($participantType) ?></dd>
      <dt>Minat</dt><dd><?= e($interestText) ?></dd>
      <dt>Catatan</dt><dd><?= e($note) ?></dd>
      <dt>Sumber</dt><dd><?= e($source) ?></dd>
    </dl>
    <a class="btn-primary" href="registration.php">Kembali ke Form</a>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
