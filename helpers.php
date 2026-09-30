<?php
// Fungsi bantu KursusKu (Pertemuan 4 + e() untuk Pertemuan 5)

function rupiah(int|float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function statusKursus(int $quota, int $registered): string
{
    return $registered >= $quota ? 'Penuh' : 'Tersedia';
}

function sisaKursi(int $quota, int $registered): int
{
    return max(0, $quota - $registered);
}

function formatTanggal(string $date): string
{
    return (new DateTimeImmutable($date))->format('d-m-Y');
}

// Escape output agar karakter khusus HTML tidak dieksekusi browser.
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Mencari satu kursus berdasarkan kode; mengembalikan array kursus atau null.
function cariKursus(array $courses, string $code): ?array
{
    foreach ($courses as $course) {
        if ($course['code'] === $code) {
            return $course;
        }
    }
    return null;
}
