<?php
include '../config/koneksi.php'; // Mengambil variabel $conn dari koneksi.php
global $conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query INSERT sesuai dengan struktur tabel users Anda
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin baru berhasil ditambahkan!'); window.location='index_admin.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
