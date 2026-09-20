<?php
function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
function statusKursus($kapasitas, $terisi) {
    return $terisi >= $kapasitas ? 'Penuh' : 'Tersedia';
}
function sisaKursi($kapasitas, $terisi) {
    return $kapasitas - $terisi;
}
function formatTanggal($tanggal) {
    return date('d-m-Y', strtotime($tanggal));
}