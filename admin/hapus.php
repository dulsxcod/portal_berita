<?php
include '../config/koneksi.php';
global $conn;


$id = $_GET['id'];

if (mysqli_query($conn, "DELETE FROM berita WHERE id = $id")) {
    header("Location: home_admin.php");
} else {
    echo "Gagal menghapus: " . mysqli_error($conn);
}
