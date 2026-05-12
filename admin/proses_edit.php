<?php
include '../config/koneksi.php';
global $conn;

$id = $_POST['id'];
$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$ringkasan = $_POST['ringkasan'];
$isi = $_POST['isi'];

if (!empty($_FILES['gambar']['name'])) {
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp_file, "gambar/" . $nama_file);
    $query = "UPDATE berita SET judul='$judul', kategori='$kategori', ringkasan='$ringkasan', isi='$isi', gambar='$nama_file' WHERE id='$id'";
} else {
    $query = "UPDATE berita SET judul='$judul', kategori='$kategori', ringkasan='$ringkasan', isi='$isi' WHERE id='$id'";
}

if (mysqli_query($conn, $query)) {
    header("Location: home_admin.php");
} else {
    echo "Gagal mengupdate berita.";
}
