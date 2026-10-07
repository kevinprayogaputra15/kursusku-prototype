<?php
// Fungsi bantu KursusKu (P4 + P5 + P6)

/** Escape output teks agar aman ditampilkan di HTML. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function formatRupiah(int $amount): string
{
    return 'Rp' . number_format($amount, 0, ',', '.');
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

/** Mencari satu kursus berdasarkan code; null jika tidak ada. */
function findCourse(array $courses, string $code): ?array
{
    foreach ($courses as $course) {
        if ($course['code'] === $code) {
            return $course;
        }
    }
    return null;
}

/** Percabangan if/elseif: persentase diskon menurut tipe peserta. */
function getDiscountPercent(string $participantType): int
{
    if ($participantType === 'mahasiswa') {
        return 20;
    } elseif ($participantType === 'guru') {
        return 15;
    }
    return 0;
}

/** switch: label metode belajar. */
function getLearningModeLabel(string $mode): string
{
    switch ($mode) {
        case 'offline':
            return 'Tatap Muka';
        case 'online':
            return 'Online';
        case 'hybrid':
            return 'Hybrid';
        default:
            return 'Tidak diketahui';
    }
}

/** Urutan hitung: subtotal -> nilai diskon -> total akhir. */
function hitungBiaya(int $fee, int $packageCount, int $discountPercent): array
{
    $gross    = $fee * $packageCount;
    $discount = intdiv($gross * $discountPercent, 100);
    return ['gross' => $gross, 'discount' => $discount, 'total' => $gross - $discount];
}

/** Ambil nilai POST berupa string (abaikan jika bukan string, mis. dimanipulasi menjadi array). */
function postString(string $key): string
{
    $value = $_POST[$key] ?? '';
    return is_string($value) ? trim($value) : '';
}
