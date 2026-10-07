<?php
// Parameter dari halaman pemanggil: $pageTitle (wajib), $siteName (opsional)
$siteName = $siteName ?? 'KursusKu';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> - <?= e($siteName) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="brand" href="index.php">
      <img src="assets/images/logo.png" alt="" width="32" height="32">
      <?= e($siteName) ?>
    </a>
    <nav aria-label="Navigasi utama">
      <a href="index.php">Beranda</a>
      <a href="index.php#katalog">Katalog</a>
      <a href="fee-calculator.php">Estimasi Biaya</a>
      <a href="history.php">History Dummy</a>
      <a href="register.php" class="nav-cta">Daftar Kursus</a>
    </nav>
  </div>
</header>
