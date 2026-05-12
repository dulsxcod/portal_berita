<?php
// admin/like_process_admin.php
include 'config/koneksi.php';
global $conn;

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // 1. Update jumlah like di tabel berita
    mysqli_query($conn, "UPDATE berita SET likes = likes + 1 WHERE id = '$id'");

    // 2. Ambil angka terbaru
    $res = mysqli_query($conn, "SELECT likes FROM berita WHERE id = '$id'");
    $data = mysqli_fetch_assoc($res);

    // 3. Kembalikan angka saja untuk dibaca oleh JavaScript
    echo number_format($data['likes']);
}
