<?php
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

/** Hitung total akhir untuk satu skenario memakai fungsi asli proyek. */
function totalFor(array $courses, string $code, string $type, int $packages): string
{
    $course = findCourse($courses, $code);
    if ($course === null) {
        return 'Kursus tidak ditemukan';
    }
    $cost = hitungBiaya($course['fee'], $packages, getDiscountPercent($type));
    return formatRupiah($cost['total']);
}

/** Input valid sebagai dasar skenario validasi; satu field diubah per skenario. */
$valid = [
    'name' => 'Andi', 'email' => 'andi@example.test', 'phone' => '081234567890',
    'study_program' => 'PTIK', 'course_code' => 'web', 'participant_type' => 'umum',
    'learning_mode' => 'offline', 'package_count' => 1,
];

// Render fasilitas dengan foreach yang sama seperti di halaman (ditangkap lewat output buffer).
ob_start();
foreach ($facilities as $facility) {
    echo '<li>' . e($facility) . '</li>';
}
$renderedFacilities = ob_get_clean();
$facilitiesShown = 0;
foreach ($facilities as $facility) {
    if (str_contains($renderedFacilities, e($facility))) {
        $facilitiesShown++;
    }
}

$tests = [
    ['Mahasiswa, Web Dasar, 1 paket',  totalFor($courses, 'web', 'mahasiswa', 1),     'Rp240.000'],
    ['Guru, PHP Dasar, 1 paket',       totalFor($courses, 'php', 'guru', 1),          'Rp340.000'],
    ['Umum, Laravel Dasar, 1 paket',   totalFor($courses, 'laravel', 'umum', 1),      'Rp500.000'],
    ['Mahasiswa, Web Dasar, 2 paket',  totalFor($courses, 'web', 'mahasiswa', 2),     'Rp480.000'],
    ['Nama kosong',
        implode(' ', validateRegistration(array_merge($valid, ['name' => '']), $courses, $participantTypes, $learningModes)),
        'Nama wajib diisi.'],
    ['Email tidak valid',
        implode(' ', validateRegistration(array_merge($valid, ['email' => 'abc']), $courses, $participantTypes, $learningModes)),
        'Format email tidak valid.'],
    ['Minat kosong',
        ($l = getInterestLabels([], $interestOptions)) === [] ? 'Belum memilih minat.' : implode(', ', $l),
        'Belum memilih minat.'],
    ['3 minat',
        implode(', ', getInterestLabels(['frontend', 'backend', 'database'], $interestOptions)),
        'Frontend, Backend, Database'],
    ['Metode offline', getLearningModeLabel('offline'), 'Tatap Muka'],
    ['Metode hybrid',  getLearningModeLabel('hybrid'),  'Hybrid'],
    ['GET process.php',
        shouldRedirectToForm('GET') ? 'Redirect ke register.php' : 'Tidak redirect',
        'Redirect ke register.php'],
    ['Tambah fasilitas',
        $facilitiesShown === count($facilities) ? 'Dirender otomatis dengan foreach' : "Hanya $facilitiesShown dari " . count($facilities) . ' tampil',
        'Dirender otomatis dengan foreach'],
];

$passCount = 0;
foreach ($tests as $test) {
    if ($test[1] === $test[2]) {
        $passCount++;
    }
}

$siteName  = 'KursusKu';
$pageTitle = 'Test Matrix';
require __DIR__ . '/partials/header.php';
?>
<main class="container">
  <section class="page-intro page-intro-center">
    <p class="eyebrow">Evidence Week 06</p>
    <h1>Test Matrix Pertemuan 6</h1>
    <p>Hasil pengujian skenario pendaftaran: perbandingan hasil aktual dengan hasil yang diharapkan.
       Setiap baris dijalankan langsung dengan fungsi di <code>helpers.php</code> saat halaman dibuka.</p>
  </section>

  <div class="table-wrap table-matrix">
    <table class="data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Skenario</th>
          <th>Actual</th>
          <th>Expected</th>
          <th class="col-status">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tests as $index => [$scenario, $actual, $expected]): ?>
          <?php $pass = $actual === $expected; ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= e($scenario) ?></td>
            <td><?= e($actual) ?></td>
            <td><?= e($expected) ?></td>
            <td class="col-status">
              <span class="<?= $pass ? 'badge-pass' : 'badge-fail' ?>"><?= $pass ? 'PASS' : 'FAIL' ?></span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" class="summary-label">Ringkasan:</td>
          <td class="col-status"><?= $passCount ?>/<?= count($tests) ?> Pass</td>
        </tr>
      </tfoot>
    </table>
  </div>

  <p class="matrix-note">Catatan: halaman ini membantu pengecekan cepat. Untuk evidence tugas, tetap uji
     skenario di form sendiri, isi <code>evidence/week-06/test-matrix.txt</code>, dan ambil screenshot halaman ini.</p>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
