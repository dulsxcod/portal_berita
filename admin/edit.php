<?php
session_start();
include '../config/koneksi.php';
global $conn;

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Berita - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Edit Postingan Berita</h5>
            </div>
            <div class="card-body">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul Berita</label>
                        <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?= $data['kategori'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="ringkasan" class="form-control" rows="3"><?= $data['ringkasan'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea name="isi" class="form-control" rows="6"><?= $data['isi'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <img src="gambar/<?= $data['gambar'] ?>" width="150" class="mb-2 rounded">
                        <input type="checkbox" name="hapus_gambar"> Ceklis jika ingin ganti gambar
                        <input type="file" name="gambar" class="form-control mt-2">
                    </div>

                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                    <a href="home_admin.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>