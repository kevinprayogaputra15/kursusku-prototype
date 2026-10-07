<?php
require_once __DIR__ . '/helpers.php';

$limit = 5;   // Latihan: ubah menjadi 3. Nilai ini yang mengontrol berhentinya semua loop.

$siteName  = 'KursusKu';
$pageTitle = 'Loop Lab';
require __DIR__ . '/partials/header.php';
?>
<main class="container">
  <section class="page-intro">
    <p class="eyebrow">Latihan Pertemuan 6</p>
    <h1>Loop Lab: for, while, do-while</h1>
    <p>Batas pengulangan: <strong><?= $limit ?></strong>. Setiap loop punya counter dan kondisi berhenti.</p>
  </section>

  <section class="form-card">
    <h2>A. for (jumlah iterasi diketahui)</h2>
    <p>
      <?php for ($i = 1; $i <= $limit; $i++) {
          echo "Pertemuan ke-$i<br>";
      } ?>
    </p>

    <h2>B. while (cek kondisi dulu)</h2>
    <p>
      <?php $i = 1;
      while ($i <= $limit) {
          echo "Nomor antrean: $i<br>";
          $i++;
      } ?>
    </p>

    <h2>C. do-while (jalan dulu, baru cek)</h2>
    <p>
      <?php $i = 1;
      do {
          echo "Percobaan ke-$i<br>";
          $i++;
      } while ($i <= $limit); ?>
    </p>

    <h2>D. Perbedaan nyata while vs do-while</h2>
    <p>
      <?php
      $i = 10;   // sengaja sudah melewati batas
      echo 'while: ';
      while ($i <= $limit) { echo 'tampil '; $i++; }
      echo '(tidak tampil sama sekali)<br>do-while: ';
      do { echo 'tampil '; $i++; } while ($i <= $limit);
      echo '(tampil satu kali)';
      ?>
    </p>

    <h2>E. if / elseif / else (prediksi dulu!)</h2>
    <div class="table-wrap">
    <table class="data-table">
      <tr><th>Tipe</th><th>Diskon</th></tr>
      <?php foreach (['mahasiswa', 'guru', 'umum', 'tidak-dikenal'] as $type): ?>
        <tr><td><?= e($type) ?></td><td><?= getDiscountPercent($type) ?>%</td></tr>
      <?php endforeach; ?>
    </table>
    </div>

    <h2>F. switch (satu variabel, banyak nilai)</h2>
    <div class="table-wrap">
    <table class="data-table">
      <tr><th>Mode</th><th>Label</th></tr>
      <?php foreach (['offline', 'online', 'hybrid', 'telepati'] as $mode): ?>
        <tr><td><?= e($mode) ?></td><td><?= e(getLearningModeLabel($mode)) ?></td></tr>
      <?php endforeach; ?>
    </table>
    </div>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
