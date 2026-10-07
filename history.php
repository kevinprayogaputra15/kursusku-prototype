<?php
require_once __DIR__ . '/helpers.php';

// Data dummy (belum database) untuk melatih foreach.
$history = [
    ['name' => 'Alya',  'course' => 'Web Dasar',     'total' => 240000],
    ['name' => 'Bima',  'course' => 'PHP Dasar',     'total' => 340000],
    ['name' => 'Citra', 'course' => 'Laravel Dasar', 'total' => 500000],
];

$grandTotal = 0;
foreach ($history as $item) {
    $grandTotal += $item['total'];
}

$siteName  = 'KursusKu';
$pageTitle = 'History Dummy';
require __DIR__ . '/partials/header.php';
?>
<main class="container">
  <section class="page-intro">
    <p class="eyebrow">Latihan Looping</p>
    <h1>History Pendaftaran (Dummy)</h1>
    <p>Data berikut hanya array latihan, bukan data nyata dan bukan CRUD.</p>
  </section>

  <div class="table-wrap table-narrow">
    <table class="data-table">
      <thead>
        <tr><th>No</th><th>Nama</th><th>Kursus</th><th>Total</th></tr>
      </thead>
      <tbody>
        <?php foreach ($history as $index => $item): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= e($item['name']) ?></td>
            <td><?= e($item['course']) ?></td>
            <td><?= formatRupiah($item['total']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr class="total"><td colspan="3">Total (<?= count($history) ?> peserta)</td><td><?= formatRupiah($grandTotal) ?></td></tr>
      </tfoot>
    </table>
  </div>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
