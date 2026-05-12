<?php
session_start();
include '../config/koneksi.php';
global $conn;

// Ambil data dari form
// Pastikan di file edit_admin.php nama inputnya adalah 'id_admin'
$id_user = $_POST['id_user'];
$username_baru = $_POST['username'];
$password = $_POST['password'];

if (!empty($password)) {
    // Gunakan 'id_admin' sebagai nama kolom yang benar sesuai struktur tabelmu
    $query = "UPDATE users SET username='$username_baru', password='$password' WHERE id_user='$id_user'";
} else {
    // Pastikan nama kolom di WHERE clause konsisten (id_admin)
    $query = "UPDATE users SET username='$username_baru' WHERE id_user='$id_user'";
}

if (mysqli_query($conn, $query)) {
    $_SESSION['username'] = $username_baru;
    header("Location: home_admin.php?pesan=update_berhasil");
} else {
    // Menampilkan error spesifik jika gagal lagi
    echo "Gagal update profile admin: " . mysqli_error($conn);
}
