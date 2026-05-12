<?php
session_start();
include '../config/koneksi.php'; // Pastikan path ini benar sesuai folder kamu
global $conn;

// Ambil username dari session login
$username_session = $_SESSION['username'];
// Query ke tabel admin (Pastikan nama tabel di phpMyAdmin adalah 'admin')
$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username_session'");
$admin = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-header {
            background: linear-gradient(45deg, #dc3545, #b02a37) !important;
            padding: 20px;
            text-align: center;
            border: none;
        }

        .card-header h5 {
            letter-spacing: 1px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ced4da;
            background-color: #fbfbfb;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }

        .btn-danger {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(45deg, #dc3545, #b02a37);
            border: none;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm border-0 col-md-6 mx-auto">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Edit Profil Admin</h5>
            </div>
            <div class="card-body">
                <form action="proses_edit_admin.php" method="POST">
                    <input type="hidden" name="id_user" value="<?= $admin['id_user']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $admin['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Simpan Perubahan</button>
                    <a href="home_admin.php" class="btn btn-link w-100 text-muted">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>