<?php
// Satu sumber data KursusKu (P4 katalog + P6 form). Ubah di sini, semua halaman ikut berubah.

$courses = [
    ['code' => 'web',       'name' => 'Web Dasar',           'fee' => 300000, 'quota' => 30, 'registered' => 12, 'start_date' => '2026-09-21'],
    ['code' => 'php',       'name' => 'PHP Dasar',           'fee' => 400000, 'quota' => 30, 'registered' => 18, 'start_date' => '2026-09-22'],
    ['code' => 'laravel',   'name' => 'Laravel Dasar',       'fee' => 500000, 'quota' => 25, 'registered' => 20, 'start_date' => '2026-09-28'],
    ['code' => 'php-lanjut','name' => 'PHP Lanjutan',        'fee' => 450000, 'quota' => 25, 'registered' => 25, 'start_date' => '2026-09-24'],
    ['code' => 'mysql',     'name' => 'MySQL Dasar',         'fee' => 350000, 'quota' => 20, 'registered' => 0,  'start_date' => '2026-10-01'],
    ['code' => 'ui-web',    'name' => 'UI Web Dasar',        'fee' => 325000, 'quota' => 35, 'registered' => 9,  'start_date' => '2026-10-03'],
];

$interestOptions = [
    'frontend' => 'Frontend',
    'backend'  => 'Backend',
    'database' => 'Database',
    'uiux'     => 'UI/UX',
];

$participantTypes = [
    'mahasiswa' => 'Mahasiswa',
    'guru'      => 'Guru',
    'umum'      => 'Umum',
];

$learningModes = ['offline', 'online', 'hybrid'];

$facilities = [
    'Modul digital',
    'Sertifikat penyelesaian',
    'Forum diskusi kelas',
];
