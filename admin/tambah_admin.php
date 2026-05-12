<?php
session_start();
include '../config/koneksi.php'; // Menggunakan koneksi dari file yang Anda miliki
global $conn;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-danger text-white fw-bold text-center">TAMBAH ANGGOTA ADMIN</div>
                    <div class="card-body">
                        <form action="proses_tambah_admin.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username Baru</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger">Simpan Admin</button>
                                <a href="index_admin.php" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>