<?php
include '../config/koneksi.php';
global $conn;


$id_berita = $_POST['id_berita'];
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

$query = "INSERT INTO komentar (id_berita, nama_user, isi_komentar) VALUES ('$id_berita', '$nama', '$komentar')";

if (mysqli_query($conn, $query)) {
    // Kembali ke halaman detail berita tadi
    header("Location: detail_admin.php?id=$id_berita");
} else {
    echo "Gagal mengirim komentar: " . mysqli_error($conn);
}
