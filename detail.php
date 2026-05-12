<?php
include 'config/koneksi.php';
$id = $_GET['id'];

// Logika: Tambah 1 view setiap kali halaman ini dibuka
if (isset($id)) {
    mysqli_query($conn, "UPDATE berita SET view_count = view_count + 1 WHERE id = '$id'");
}

// Query SELECT untuk menampilkan isi berita
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?> | SMK YAPIIM NEWS</title>
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
            /* Memberikan efek background yang sama dengan index */
            background-image: linear-gradient(rgba(248, 249, 252, 0.9), rgba(248, 249, 252, 0.9)),
                url('https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=2070');
            background-size: cover;
            background-attachment: fixed;
        }

        /* Navbar Premium (Sama dengan Index) */
        .navbar {
            background: linear-gradient(135deg, var(--primary-premium), #8b0000) !important;
            padding: 1rem 0;
            border-bottom: 3px solid var(--gold-accent);
        }

        .navbar-brand {
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Container Berita */
        .article-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 40px;
        }

        .main-img {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            object-fit: cover;
            max-height: 500px;
        }

        .badge-category {
            background: #fff5f5;
            color: var(--primary-premium);
            border: 1px solid #ffe3e3;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 0.8rem;
        }

        .article-title {
            font-weight: 800;
            letter-spacing: -1.5px;
            color: var(--dark-luxury);
            line-height: 1.2;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.9;
            color: #444;
            text-align: justify;
        }

        /* Form Komentar Premium */
        .comment-section-title {
            border-bottom: 2px solid var(--primary-premium);
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 25px;
        }

        .form-comment-bg {
            background: #fdfdfd;
            border: 1px solid #eee;
            border-radius: 18px;
            padding: 25px;
        }

        /* List Komentar (Sama dengan detail lama namun diperhalus) */
        .user-comment-card {
            border-left: 4px solid var(--primary-premium) !important;
            background: #fff;
            padding: 20px;
            border-radius: 0 15px 15px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: 0.3s;
        }

        .user-comment-card:hover {
            background: #fffafa;
            transform: translateX(5px);
        }

        footer {
            border-top: 5px solid var(--primary-premium);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <span class="text-white">SMK YAPIIM</span> <span style="color: var(--gold-accent);">NEWS</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-light btn-sm rounded-pill px-4 fw-bold"> Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <article class="article-card mb-5">
                    <span class="badge-category"><?= strtoupper($data['kategori']) ?></span>
                    <h1 class="article-title mb-3"><?= $data['judul'] ?></h1>
                    
                    <div class="d-flex align-items-center gap-3 mb-4 text-muted small">
                        <span><i class="bi bi-calendar"></i> 📅 <?= date('d M Y', strtotime($data['tanggal'])) ?></span>
                        <span>•</span>
                        <span>👁️ <?= number_format($data['view_count']) ?> Pembaca</span>
                    </div>

                    <img src="admin/gambar/<?= !empty($data['gambar']) ? $data['gambar'] : 'https://via.placeholder.com/800x450' ?>" 
                         class="img-fluid main-img w-100" alt="<?= $data['judul'] ?>">

                    <div class="article-content">
                        <p><?= nl2br($data['isi']) ?></p>
                    </div>

                    <hr class="my-5">

                    <div class="comment-area">
                        <h4 class="fw-800 comment-section-title">Tinggalkan Respon</h4>
                        
                        <div class="form-comment-bg shadow-sm mb-5">
                            <form action="proses_komentar.php" method="POST">
                                <input type="hidden" name="id_berita" value="<?= $id ?>">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Nama Anda</label>
                                    <input type="text" name="nama" class="form-control border-0 bg-light p-3" 
                                           style="border-radius: 12px;" placeholder="Masukkan nama..." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Pesan Komentar</label>
                                    <textarea name="komentar" class="form-control border-0 bg-light p-3" 
                                              style="border-radius: 12px;" rows="4" placeholder="Tulis pendapat anda..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 shadow-sm fw-bold" 
                                        style="background: var(--primary-premium); border:none; font-size: 0.9rem;">
                                    Kirim Komentar
                                </button>
                            </form>
                        </div>

                        <h5 class="fw-800 mb-4 text-dark">Komentar Terbaru</h5>
                        <?php
                        $ambil_komentar = mysqli_query($conn, "SELECT * FROM komentar WHERE id_berita = $id ORDER BY id_komentar DESC");
                        if (mysqli_num_rows($ambil_komentar) > 0) {
                            while ($k = mysqli_fetch_array($ambil_komentar)) {
                        ?>
                            <div class="user-comment-card mb-4 border-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark"><?= htmlspecialchars($k['nama_user']) ?></strong>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?= $k['tanggal_komentar'] ?></small>
                                </div>
                                <p class="mb-0 text-muted small"><?= nl2br(htmlspecialchars($k['isi_komentar'])) ?></p>
                            </div>
                        <?php 
                            } 
                        } else {
                            echo "<div class='text-center py-4 bg-light rounded-4'><p class='text-muted mb-0'>Belum ada komentar. Jadilah yang pertama!</p></div>";
                        }
                        ?>
                    </div>
                </article>

            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-5">
        <div class="container">
            <h5 class="fw-800 mb-1" style="letter-spacing: 2px;">SMK YAPIIM <span class="text-danger">NEWS</span></h5>
            <p class="text-secondary small mb-0">Portal Informasi Terpadu &copy; 2026</p>
            <div class="mt-3">
                <small class="text-muted">Developed by <span class="text-white fw-bold">DulsXcode</span></small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>