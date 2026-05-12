<?php
include '../config/koneksi.php';
global $conn;

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Gunakan BINARY untuk memastikan pengecekan case-sensitive (membedakan huruf besar/kecil)
$query = mysqli_query($conn, "SELECT * FROM users WHERE BINARY username='$username' AND BINARY password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $_SESSION['status'] = "login";
    $_SESSION['username'] = $username;
    // Catatan: Sebaiknya jangan menyimpan password mentah di dalam SESSION untuk keamanan
    header("location:home_admin.php");
    exit();
} else {
    echo "<script>alert('Login Gagal! Username atau Password salah'); window.location='index.php';</script>";
}
