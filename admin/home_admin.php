<?php
session_start();
// Pastikan path ke koneksi benar. Keluar dari folder admin (../), lalu masuk ke folder config.
include '../config/koneksi.php';
global $conn;

$query_total_berita = mysqli_query($conn, "SELECT id FROM berita");
$total_berita = mysqli_num_rows($query_total_berita);
$query_total_komentar = mysqli_query($conn, "SELECT id_komentar FROM komentar");
$total_komentar = mysqli_num_rows($query_total_komentar);

// LOGIKA: Ambil input kategori DAN search
$kategori_terpilih = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query_total_views = mysqli_query($conn, "SELECT SUM(view_count) as total_semua_view FROM berita");
$data_views = mysqli_fetch_array($query_total_views);
$total_views = $data_views['total_semua_view'] ?? 0;
$query_total_likes = mysqli_query($conn, "SELECT SUM(likes) as total_semua_like FROM berita");
$data_likes = mysqli_fetch_array($query_total_likes);
$total_likes = $data_likes['total_semua_like'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Admin Dashboard - Portal News</title>
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

        /* Navbar Enhancements */
        .navbar {
            background: linear-gradient(135deg, var(--primary-premium), #8b0000) !important;
            padding: 1rem 0;
            border-bottom: 3px solid var(--gold-accent);
        }

        .navbar-brand {
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Stat Cards Luxury */
        .stat-card {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-card .card-body {
            padding: 1.5rem;
            z-index: 2;
            position: relative;
        }

        .stat-icon {
            font-size: 2.5rem;
            position: absolute;
            right: 15px;
            bottom: 10px;
            opacity: 0.2;
            transition: 0.3s;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(-10deg);
            opacity: 0.4;
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

        .hero-content h1 {
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Modern Table Styling */
        .table-wrapper {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .table thead th {
            background-color: transparent;
            border-bottom: 2px solid #f1f1f1;
            color: #a0a0a0;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1.5px;
            padding-bottom: 20px;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        /* PERBAIKAN: Menghapus transform scale untuk mencegah layar bergetar */
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .news-thumbnail {
            width: 80px;
            height: 55px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Action Buttons */
        .btn-action {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            margin: 0 2px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .btn-outline-info {
            background: #e1f5fe;
            color: #0288d1;
        }

        .btn-outline-primary {
            background: #e8eaf6;
            color: #3f51b5;
        }

        .btn-outline-dark {
            background: #efebe9;
            color: #4e342e;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            filter: brightness(0.9);
            color: inherit;
        }

        /* Custom Badge */
        .badge-category {
            background: #fff5f5;
            color: var(--primary-premium);
            border: 1px solid #ffe3e3;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 10px;
        }

        /* Custom Search Box */
        .input-group .form-control {
            border-radius: 10px 0 0 10px;
            border: 1px solid #eee;
            padding-left: 15px;
        }

        .input-group .btn-dark {
            border-radius: 0 10px 10px 0;
            background: var(--dark-luxury);
        }

        /* Dropdown Profile */
        .bg-profile-icon {
            background: linear-gradient(45deg, #eee, #fff);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.like-btn');
        if (btn) {
            const idBerita = btn.getAttribute('data-id');
            const spanAngka = document.getElementById('like-count-' + idBerita);
            let formData = new FormData();
            formData.append('id', idBerita);

            fetch('like_process_admin.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(hasil => {
                    if (hasil) {
                        spanAngka.innerText = hasil;
                        btn.classList.replace('btn-outline-secondary', 'btn-danger');
                        btn.style.color = 'white';
                        btn.style.backgroundColor = '#dc3545';
                    }
                })
                .catch(err => console.error("Gagal Like:", err));
        }
    });
</script>

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

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $kategori_terpilih == '' ? 'active fw-bold text-white' : '' ?>" href="home_admin.php">Semua Berita</a>
                    </li>
                    <?php
                    $query_kategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM berita WHERE kategori != ''");
                    while ($kat = mysqli_fetch_array($query_kategori)) {
                        $nama_kat = $kat['kategori'];
                        $active = ($kategori_terpilih == $nama_kat) ? 'active fw-bold text-white' : '';
                        echo "<li class='nav-item'><a class='nav-link $active' href='home_admin.php?kategori=$nama_kat'>$nama_kat</a></li>";
                    }
                    ?>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <form action="home_admin.php" method="GET" class="d-flex me-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari data..." value="<?= htmlspecialchars($search) ?>">
                            <button class="btn btn-dark btn-sm px-3" type="submit">Cari</button>
                        </div>
                    </form>

                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-2 dropdown-toggle" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                            <div class="text-white d-none d-md-block text-end">
                                <small class="d-block text-white-50" style="font-size: 0.6rem; letter-spacing: 1px;">AUTHENTICATED</small>
                                <span class="fw-bold" style="font-size: 0.9rem;"><?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Administrator'; ?></span>
                            </div>
                            <div class="bg-profile-icon rounded-circle d-flex align-items-center justify-content-center border border-2 border-white" style="width: 42px; height: 42px;">
                                <span class="text-danger fw-bold">
                                    <?= isset($_SESSION['username']) ? strtoupper(substr($_SESSION['username'], 0, 1)) : 'A'; ?>
                                </span>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3" aria-labelledby="dropdownUser" style="border-radius: 15px; overflow: hidden;">
                            <li>
                                <h6 class="dropdown-header py-3 bg-light">Manajemen Konten</h6>
                            </li>
                            <li><a class="dropdown-item py-2" href="tambah.php">✨ Tambah Postingan</a></li>
                            <li><a class="dropdown-item py-2" href="tambah_admin.php">🔑 Tambah Akun</a></li>
                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>
                            <li><a class="dropdown-item py-2" href="edit_admin.php">⚙️ Pengaturan Profil</a></li>
                            <li><a class="dropdown-item py-2 text-danger fw-bold" href="../index.php" onclick="return confirm('Yakin ingin keluar?')">🚪 Keluar Sistem</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow-1">
        <div class="container mt-5">
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card bg-white text-dark h-100 border-start border-primary border-4">
                        <div class="card-body">
                            <div class="text-muted small fw-bold mb-1">TOTAL POSTS</div>
                            <div class="h2 fw-800 mb-0"><?= $total_berita ?></div>
                            <div class="stat-icon text-primary">📰</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card bg-white text-dark h-100 border-start border-success border-4">
                        <div class="card-body">
                            <div class="text-muted small fw-bold mb-1">COMMENTS</div>
                            <div class="h2 fw-800 mb-0"><?= $total_komentar ?></div>
                            <div class="stat-icon text-success">💬</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card bg-white text-dark h-100 border-start border-warning border-4">
                        <div class="card-body">
                            <div class="text-muted small fw-bold mb-1">TOTAL READS</div>
                            <div class="h2 fw-800 mb-0"><?= number_format($total_views) ?></div>
                            <div class="stat-icon text-warning">👁️</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card bg-white text-dark h-100 border-start border-danger border-4">
                        <div class="card-body">
                            <div class="text-muted small fw-bold mb-1">APPRECIATIONS</div>
                            <div class="h2 fw-800 mb-0"><?= number_format($total_likes) ?></div>
                            <div class="stat-icon text-danger">❤️</div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($kategori_terpilih == '' && $search == ''): ?>
                <header class="hero-section text-center text-white">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto hero-content">
                                <h1 class="display-5 mb-3">Selamat Datang di Portal Eksklusif</h1>
                                <p class="lead opacity-75 mb-0 font-weight-light">Kelola narasi dan informasi terbaik untuk Civitas Akademika SMK YAPIIM Indramayu.</p>
                            </div>
                        </div>
                    </div>
                </header>
            <?php endif; ?>

            <div class="table-wrapper mb-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h4 class="fw-800 mb-1 text-dark">
                            <?php
                            if ($search) {
                                echo "Hasil Penelusuran";
                            } else {
                                echo $kategori_terpilih ? "Kategori: " . htmlspecialchars($kategori_terpilih) : "Katalog Konten Utama";
                            }
                            ?>
                        </h4>
                        <p class="text-muted small mb-0">Menampilkan data berita terpopuler saat ini.</p>
                    </div>
                    <a href="tambah.php" class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm" style="background: var(--primary-premium); border:none;">
                        + Buat Berita Baru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" width="50">ID</th>
                                <th>KONTEN BERITA</th>
                                <th>KLASIFIKASI</th>
                                <th class="text-center">ENGAGEMENT</th>
                                <th>PUBLIKASI</th>
                                <th class="text-center">MANAJEMEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM berita WHERE 1=1";
                            if ($kategori_terpilih) $sql .= " AND kategori = '$kategori_terpilih'";
                            if ($search) $sql .= " AND (judul LIKE '%$search%' OR ringkasan LIKE '%$search%')";

                            $sql .= " ORDER BY (view_count + likes) DESC, id DESC";

                            $ambil_data = mysqli_query($conn, $sql);
                            $no = 1;

                            if (mysqli_num_rows($ambil_data) == 0) {
                                echo "<tr><td colspan='6' class='text-center py-5 text-muted'>Tidak ada data ditemukan dalam database.</td></tr>";
                            }

                            while ($row = mysqli_fetch_array($ambil_data)) {
                            ?>
                                <tr>
                                    <td class="text-center text-muted font-monospace small"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="gambar/<?= $row['gambar'] ? $row['gambar'] : 'https://via.placeholder.com/60x45' ?>" class="news-thumbnail me-3">
                                            <div style="max-width: 300px;">
                                                <div class="fw-bold text-dark mb-1 small text-truncate"><?= $row['judul'] ?></div>
                                                <div class="text-muted" style="font-size: 0.65rem; line-height: 1.4;">
                                                    <?= substr(strip_tags($row['ringkasan']), 0, 65) ?>...
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-category small">
                                            <?= strtoupper($row['kategori']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-block text-start">
                                            <div class="small text-muted mb-1" style="font-size: 0.7rem;">👁️ <?= number_format($row['view_count']) ?> Views</div>
                                            <button type="button" class="btn btn-sm like-btn p-0 border-0 text-danger fw-bold" data-id="<?= $row['id'] ?>" style="font-size: 0.75rem;">
                                                ❤️ <span id="like-count-<?= $row['id'] ?>"><?= number_format($row['likes']) ?></span> Likes
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark small"><?= date('d M', strtotime($row['tanggal'])) ?></div>
                                        <div class="text-muted" style="font-size: 0.6rem;"><?= date('Y', strtotime($row['tanggal'])) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="detail_admin.php?id=<?= $row['id'] ?>" class="btn-action btn-outline-info" title="Lihat">👁️</a>
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn-action btn-outline-primary" title="Ubah">✏️</a>
                                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn-action btn-outline-dark" onclick="return confirm('Hapus permanen berita ini?')" title="Hapus">🗑️</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-5 mt-auto" style="border-top: 5px solid var(--primary-premium);">
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