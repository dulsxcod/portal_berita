<?php
session_start();
// Pastikan path ke koneksi benar. Keluar dari folder admin (../), lalu masuk ke folder config.
include '../config/koneksi.php';
global $conn;

$id = $_GET['id'];

// Ambil data berita berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id = $id");
$data = mysqli_fetch_array($query);

// Logika: Tambah 1 view setiap kali halaman ini dibuka
if (isset($id)) {
    mysqli_query($conn, "UPDATE berita SET view_count = view_count + 1 WHERE id = '$id'");
}

// Mengambil nama pengguna dari session akun yang sedang aktif
$nama_pengguna_login = isset($_SESSION['username']) ? $_SESSION['username'] : 'username';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konten | Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-premium: #c82333;
            --dark-luxury: #1a1a1a;
            --soft-bg: #f8f9fc;
            --gold-accent: #d4af37;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
            color: #2d3436;
            letter-spacing: -0.01em;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-premium), #8b0000) !important;
            padding: 1rem 0;
            border-bottom: 3px solid var(--gold-accent);
        }

        .navbar-brand {
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Card Styling Luxury */
        .article-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 30px;
        }

        .main-img {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            object-fit: cover;
            max-height: 500px;
            width: 100%;
        }

        .badge-category {
            background: #fff5f5;
            color: var(--primary-premium);
            border: 1px solid #ffe3e3;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 0.8rem;
        }

        .article-title {
            font-weight: 800;
            color: var(--dark-luxury);
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
        }

        /* Comment Styling */
        .comment-section-title {
            border-left: 5px solid var(--primary-premium);
            padding-left: 15px;
            margin-top: 50px;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .user-comment-card {
            background: #fff;
            border-left: 5px solid var(--primary-premium) !important;
            border-radius: 0 15px 15px 0;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: 0.3s;
        }

        .user-comment-card:hover {
            background: #fff5f5;
        }

        .btn-premium {
            background: var(--primary-premium);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-premium:hover {
            background: #a71d2a;
            color: white;
            transform: translateY(-2px);
        }

        footer {
            border-top: 5px solid var(--primary-premium);
        }

        /* Input Locked Styling agar user tahu ini tidak bisa diubah */
        .input-locked {
            background-color: #f1f3f5 !important;
            cursor: not-allowed;
            font-weight: 600;
            color: #495057;
            border: 1px solid #dee2e6 !important;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="home_admin.php">
                <span class="text-white">SMK YAPIIM</span> <span style="color: var(--gold-accent);">NEWS</span>
                <span class="badge bg-dark ms-2" style="font-size: 0.5rem; vertical-align: middle; border: 1px solid var(--gold-accent);">PRO PANEL</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
    </nav>

    <div class="container flex-grow-1 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="article-card">

                    <span class="badge-category"><?= strtoupper($data['kategori']) ?></span>
                    <h1 class="article-title"><?= $data['judul'] ?></h1>

                    <div class="d-flex align-items-center gap-3 text-muted small mb-4">
                        <span>📅 <?= date('d M Y', strtotime($data['tanggal'])) ?></span>
                        <span>•</span>
                        <span>👁️ <?= number_format($data['view_count']) ?> Views</span>
                    </div>

                    <hr>

                    <img src="../admin/gambar/<?= !empty($data['gambar']) ? $data['gambar'] : 'https://via.placeholder.com/800x450' ?>"
                        class="main-img" alt="content">

                    <div class="article-content">
                        <p><?= nl2br($data['isi']) ?></p>
                    </div>

                    <div class="mt-5 p-4 rounded-4 bg-light">
                        <h5 class="fw-bold mb-3">Tulis Balasan / Komentar</h5>
                        <form action="proses_komentar.php" method="POST">
                            <input type="hidden" name="id_berita" value="<?= $id ?>">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Nama Admin</label>
                                <input type="text" name="nama" class="form-control p-3 input-locked"
                                    value="<?= $nama_pengguna_login ?>" readonly required style="border-radius: 12px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Isi Komentar</label>
                                <textarea name="komentar" class="form-control border-0 p-3" rows="3"
                                    placeholder="Tulis balasan anda..." required style="border-radius: 12px;"></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-premium btn-sm shadow-sm">Kirim Komentar</button>
                                <a href="home_admin.php" class="btn btn-secondary btn-sm rounded-pill px-4">Batal</a>
                            </div>
                        </form>
                    </div>

                    <h5 class="comment-section-title">Komentar Terbaru</h5>
                    <?php
                    $ambil_komentar = mysqli_query($conn, "SELECT * FROM komentar WHERE id_berita = $id ORDER BY id_komentar DESC");
                    if (mysqli_num_rows($ambil_komentar) > 0) {
                        while ($k = mysqli_fetch_array($ambil_komentar)) {
                    ?>
                            <div class="user-comment-card border-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark"><?= htmlspecialchars($k['nama_user']) ?></strong>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?= $k['tanggal_komentar'] ?></small>
                                </div>
                                <p class="mt-2 mb-0 text-muted small"><?= nl2br(htmlspecialchars($k['isi_komentar'])) ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center text-muted py-4'>Belum ada komentar pada postingan ini.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-5 mt-auto">
        <div class="container">
            <h5 class="fw-800 mb-1" style="letter-spacing: 2px;">PORTAL <span class="text-danger">NEWS</span></h5>
            <p class="text-secondary small mb-0">Sistem Manajemen Konten Terpadu &copy; 2026</p>
            <div class="mt-3">
                <small class="text-muted">Developed by <span class="text-white fw-bold">DulsXcode</span></small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>