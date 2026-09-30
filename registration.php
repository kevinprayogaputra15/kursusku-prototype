<?php
require_once __DIR__ . '/helpers.php';

$courses   = require __DIR__ . '/data/courses.php';
$pageTitle = 'Daftar Kursus';
require __DIR__ . '/partials/header.php';
?>
<main class="container">
  <section class="page-intro">
    <p class="eyebrow">Pendaftaran Kursus</p>
    <h1>Mulai belajar bersama KursusKu</h1>
    <p>Gunakan data latihan. Field bertanda <span class="req">*</span> wajib diisi.</p>
  </section>

  <section class="form-card">
    <form action="process-registration.php" method="POST" class="registration-form">
      <!-- Hidden field: dikirim ke server, tidak terlihat pengguna -->
      <input type="hidden" name="source" value="week-05">

      <div class="form-grid">
        <div class="form-group">
          <label for="name">Nama Lengkap <span class="req">*</span></label>
          <input id="name" name="name" type="text" minlength="3" maxlength="100"
                 autocomplete="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email <span class="req">*</span></label>
          <input id="email" name="email" type="email" maxlength="120"
                 autocomplete="email" placeholder="nama@example.test" required>
        </div>
        <div class="form-group">
          <label for="phone">Nomor HP <span class="req">*</span></label>
          <input id="phone" name="phone" type="tel" maxlength="15" autocomplete="tel"
                 placeholder="Contoh: 081234567890" required>
        </div>
        <div class="form-group">
          <label for="study_program">Program Studi <span class="req">*</span></label>
          <input id="study_program" name="study_program" type="text" maxlength="100" required>
        </div>
      </div>

      <div class="form-group">
        <label for="course">Kursus yang Dipilih <span class="req">*</span></label>
        <select id="course" name="course" required>
          <option value="">-- Pilih kursus --</option>
          <?php foreach ($courses as $course): ?>
            <?php $full = statusKursus($course['quota'], $course['registered']) === 'Penuh'; ?>
            <option value="<?= e($course['code']) ?>" <?= $full ? 'disabled' : '' ?>>
              <?= e($course['name']) ?> - <?= rupiah($course['fee']) ?><?= $full ? ' (Penuh)' : '' ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <fieldset class="form-group">
        <legend>Jenis Peserta <span class="req">*</span></legend>
        <label class="choice">
          <input type="radio" name="participant_type" value="mahasiswa" required> Mahasiswa
        </label>
        <label class="choice">
          <input type="radio" name="participant_type" value="umum"> Umum
        </label>
      </fieldset>

      <fieldset class="form-group">
        <legend>Minat Tambahan</legend>
        <label class="choice"><input type="checkbox" name="interests[]" value="ui-ux"> UI/UX</label>
        <label class="choice"><input type="checkbox" name="interests[]" value="database"> Database</label>
        <label class="choice"><input type="checkbox" name="interests[]" value="backend"> Backend</label>
      </fieldset>

      <div class="form-group">
        <label for="note">Catatan</label>
        <textarea id="note" name="note" rows="5" maxlength="300"
                  placeholder="Tuliskan kebutuhan belajar Anda (opsional)"></textarea>
        <small class="help">Maksimal 300 karakter.</small>
      </div>

      <button class="btn-primary" type="submit">Kirim Pendaftaran</button>
    </form>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
