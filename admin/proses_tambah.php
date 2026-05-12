<?php
// Gunakan ../ untuk keluar dari folder admin, lalu masuk ke config
include '../config/koneksi.php';
global $conn;

$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$gambar = $_POST['gambar'];
$ringkasan = $_POST['ringkasan'];
$isi = $_POST['isi'];

// Variabel $conn sekarang akan terbaca dari file koneksi.php
$query = "INSERT INTO berita (judul, kategori, gambar, ringkasan, isi) VALUES ('$judul', '$kategori', '$gambar', '$ringkasan', '$isi')";

if (mysqli_query($conn, $query)) {
    // Kembali ke halaman utama yang ada di luar folder admin
    header("Location: home_admin.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
