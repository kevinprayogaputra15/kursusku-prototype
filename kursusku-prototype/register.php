<?php
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

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
    <form method="POST" action="process.php" class="registration-form">
      <input type="hidden" name="source" value="week-06">

      <div class="form-grid">
        <div class="form-group">
          <label for="name">Nama Lengkap <span class="req">*</span></label>
          <input id="name" name="name" type="text" minlength="3" maxlength="100" autocomplete="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email <span class="req">*</span></label>
          <input id="email" name="email" type="email" maxlength="120" autocomplete="email"
                 placeholder="nama@example.test" required>
        </div>
        <div class="form-group">
          <label for="phone">Nomor HP <span class="req">*</span></label>
          <input id="phone" name="phone" type="tel" maxlength="15" autocomplete="tel"
                 placeholder="Contoh: 081234567890" required>
        </div>
        <div class="form-group">
          <label for="study_program">Program Studi / Instansi <span class="req">*</span></label>
          <input id="study_program" name="study_program" type="text" maxlength="100" required>
        </div>
      </div>

      <div class="form-group">
        <label for="course_code">Pilih Kursus <span class="req">*</span></label>
        <select id="course_code" name="course_code" required>
          <option value="">-- Pilih kursus --</option>
          <?php foreach ($courses as $course): ?>
            <?php $full = statusKursus($course['quota'], $course['registered']) === 'Penuh'; ?>
            <option value="<?= e($course['code']) ?>" <?= $full ? 'disabled' : '' ?>>
              <?= e($course['name']) ?> - <?= formatRupiah($course['fee']) ?><?= $full ? ' (Penuh)' : '' ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <fieldset class="form-group">
        <legend>Tipe Peserta <span class="req">*</span></legend>
        <?php $first = true; ?>
        <?php foreach ($participantTypes as $value => $label): ?>
          <label class="choice">
            <input type="radio" name="participant_type" value="<?= e($value) ?>" <?= $first ? 'required' : '' ?>>
            <?= e($label) ?>
          </label>
          <?php $first = false; ?>
        <?php endforeach; ?>
        <small class="help">Diskon: Mahasiswa 20%, Guru 15%, Umum 0%.</small>
      </fieldset>

      <div class="form-grid">
        <div class="form-group">
          <label for="learning_mode">Metode Belajar <span class="req">*</span></label>
          <select id="learning_mode" name="learning_mode" required>
            <option value="">-- Pilih metode --</option>
            <?php foreach ($learningModes as $mode): ?>
              <option value="<?= e($mode) ?>"><?= e(getLearningModeLabel($mode)) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="package_count">Jumlah Paket <span class="req">*</span></label>
          <select id="package_count" name="package_count" required>
            <?php for ($i = 1; $i <= 3; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?> paket</option>
            <?php endfor; ?>
          </select>
        </div>
      </div>

      <fieldset class="form-group">
        <legend>Minat Belajar</legend>
        <?php foreach ($interestOptions as $value => $label): ?>
          <label class="choice">
            <input type="checkbox" name="interests[]" value="<?= e($value) ?>">
            <?= e($label) ?>
          </label>
        <?php endforeach; ?>
      </fieldset>

      <div class="form-group">
        <label for="notes">Catatan Tambahan</label>
        <textarea id="notes" name="notes" rows="4" maxlength="300"
                  placeholder="Tuliskan kebutuhan belajar Anda (opsional)"></textarea>
        <small class="help">Maksimal 300 karakter.</small>
      </div>

      <button class="btn-primary" type="submit">Proses Pendaftaran</button>
    </form>
  </section>

  <section class="form-card">
    <h2>Fasilitas yang Anda Dapatkan</h2>
    <ul class="check-list">
      <?php foreach ($facilities as $facility): ?>
        <li><?= e($facility) ?></li>
      <?php endforeach; ?>
    </ul>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
