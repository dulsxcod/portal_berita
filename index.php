<?php
// Mengambil koneksi dari folder config
include 'config/koneksi.php';
global $conn;

// Logika untuk filter kategori & pencarian
$kategori_terpilih = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Mengambil data statistik untuk counter (Opsional, agar sama dengan dashboard)
$query_total_berita = mysqli_query($conn, "SELECT id FROM berita");
$total_berita = mysqli_num_rows($query_total_berita);
$query_total_views = mysqli_query($conn, "SELECT SUM(view_count) as total_semua_view FROM berita");
$data_views = mysqli_fetch_array($query_total_views);
$total_views = $data_views['total_semua_view'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal News | Informasi Terkini SMK YAPIIM</title>
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

        /* Navbar Styling from Admin */
        .navbar {
            background: linear-gradient(135deg, var(--primary-premium), #8b0000) !important;
            padding: 1rem 0;
            border-bottom: 3px solid var(--gold-accent);
        }

        .navbar-brand {
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Hero Section Premium */
        .hero-section {
            background: linear-gradient(rgba(26, 26, 26, 0.8), rgba(26, 26, 26, 0.8)),
                url('https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=2070');
            background-size: cover;
            background-attachment: fixed;
            border-radius: 24px;
            padding: 80px 20px;
            margin-bottom: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Card Styling to Match Admin Table Luxury */
        .news-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .badge-category {
            background: #fff5f5;
            color: var(--primary-premium);
            border: 1px solid #ffe3e3;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 10px;
            font-size: 0.75rem;
        }

        /* Comment Section Style */
        .comment-preview {
            background: var(--soft-bg);
            border-radius: 12px;
            padding: 12px;
            font-size: 0.8rem;
            border-left: 3px solid var(--primary-premium);
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $kategori_terpilih == '' ? 'active fw-bold text-white' : '' ?>" href="index.php">Semua Berita</a>
                    </li>
                    <?php
                    $query_kategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM berita WHERE kategori != ''");
                    while ($kat = mysqli_fetch_array($query_kategori)) {
                        $nama_kat = $kat['kategori'];
                        $active = ($kategori_terpilih == $nama_kat) ? 'active fw-bold text-white' : '';
                        echo "<li class='nav-item'><a class='nav-link $active' href='index.php?kategori=$nama_kat'>$nama_kat</a></li>";
                    }
                    ?>
                </ul>

                <form action="index.php" method="GET" class="d-flex align-items-center gap-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari berita..." value="<?= htmlspecialchars($search) ?>" style="border-radius: 10px 0 0 10px;">
                        <button class="btn btn-dark btn-sm px-3" type="submit" style="border-radius: 0 10px 10px 0; background: var(--dark-luxury);">Cari</button>
                    </div>
                    <a href="admin/index.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Login Admin</a>
                </form>
            </div>
        </div>
    </nav>

    <?php if ($kategori_terpilih == '' && $search == ''): ?>
        <div class="container mt-5">
            <header class="hero-section text-center text-white">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h1 class="display-5 fw-800 mb-3">Informasi Terpercaya & Terkini</h1>
                        <p class="lead opacity-75 mb-4">Menyajikan berita pilihan SMK YAPIIM Indramayu secara real-time dan transparan.</p>
                        <a href="#berita" class="btn btn-danger btn-lg rounded-pill px-5 shadow-sm" style="background: var(--primary-premium); border:none;">Mulai Membaca</a>
                    </div>
                </div>
            </header>
        </div>
    <?php endif; ?>

    <div class="flex-grow-1" id="berita">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-800 mb-1 text-dark">
                        <?php
                        if ($search) echo "Hasil Pencarian: '" . htmlspecialchars($search) . "'";
                        else if ($kategori_terpilih) echo "Kategori: " . htmlspecialchars($kategori_terpilih);
                        else echo "Katalog Berita Utama";
                        ?>
                    </h4>
                    <p class="text-muted small mb-0">Total narasi saat ini: <?= $total_berita ?> konten.</p>
                </div>
            </div>

            <div class="row g-4">
                <?php
                $sql = "SELECT * FROM berita WHERE 1=1";
                if ($kategori_terpilih) $sql .= " AND kategori = '$kategori_terpilih'";
                if ($search) $sql .= " AND (judul LIKE '%$search%' OR ringkasan LIKE '%$search%')";

                $sql .= " ORDER BY (view_count + likes) DESC, id DESC";
                $ambil_data = mysqli_query($conn, $sql);

                if (mysqli_num_rows($ambil_data) == 0) {
                    echo "<div class='col-12 text-center py-5'><p class='text-muted'>Berita tidak ditemukan.</p></div>";
                }

                while ($row = mysqli_fetch_array($ambil_data)) {
                    $id_berita = $row['id'];
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="news-card h-100 shadow-sm">
                            <img src="admin/gambar/<?= $row['gambar'] ? $row['gambar'] : 'https://via.placeholder.com/400x250' ?>" class="card-img-top" alt="News Image">
                            <div class="card-body p-4">
                                <span class="badge-category"><?= strtoupper($row['kategori']) ?></span>
                                <h5 class="fw-bold text-dark mb-2"><?= $row['judul'] ?></h5>
                                <p class="text-muted small mb-4"><?= substr(strip_tags($row['ringkasan']), 0, 100) ?>...</p>

                                <div class="comment-preview mb-3">
                                    <p class="fw-bold mb-1 text-dark border-bottom pb-1" style="font-size: 0.7rem;">KOMENTAR TERBARU</p>
                                    <?php
                                    $query_komen = mysqli_query($conn, "SELECT * FROM komentar WHERE id_berita = $id_berita ORDER BY id_komentar DESC LIMIT 1");
                                    if (mysqli_num_rows($query_komen) > 0) {
                                        $komen = mysqli_fetch_array($query_komen);
                                        echo "<div><span class='text-danger fw-bold'>{$komen['nama_user']}: </span><span class='text-muted'>{$komen['isi_komentar']}</span></div>";
                                    } else {
                                        echo "<p class='text-muted fst-italic mb-0'>Belum ada respon.</p>";
                                    }
                                    ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="engagement-info">
                                        <div class="small text-muted" style="font-size: 0.7rem;">
                                            👁️ <?= number_format($row['view_count']) ?> | 
                                            <button class="btn btn-sm like-btn p-0 border-0 text-danger fw-bold" data-id="<?= $row['id'] ?>" style="font-size: 0.7rem;">
                                                ❤️ <span id="like-count-<?= $row['id'] ?>"><?= number_format($row['likes']) ?></span>
                                            </button>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.65rem;"><?= date('d M Y', strtotime($row['tanggal'])) ?></div>
                                    </div>
                                    <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm rounded-pill px-4" style="background: var(--primary-premium); border:none; font-size: 0.8rem;">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-5 mt-5">
        <div class="container">
            <h5 class="fw-800 mb-1" style="letter-spacing: 2px;">SMK YAPIIM <span class="text-danger">NEWS</span></h5>
            <p class="text-secondary small mb-0">Portal Informasi Terpadu &copy; 2026</p>
            <div class="mt-3">
                <small class="text-muted">Developed by <span class="text-white fw-bold">DulsXcode</span></small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika Like Async (Sama dengan admin & index lama)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.like-btn');
            if (btn) {
                const idBerita = btn.getAttribute('data-id');
                const spanAngka = document.getElementById('like-count-' + idBerita);
                let formData = new FormData();
                formData.append('id', idBerita);
                fetch('like_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.text())
                    .then(hasil => {
                        if (hasil) {
                            spanAngka.innerText = hasil;
                            btn.style.color = '#c82333';
                        }
                    });
            }
        });
    </script>
</body>

</html>