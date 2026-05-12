<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h2 class="mb-4">Tambah Berita Baru</h2>
            <form action="proses_tambah.php" method="POST">
                <div class="mb-3">
                    <label>Judul Berita</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="Nasional">Nasional</option>
                        <option value="Tekno">Tekno</option>
                        <option value="Ekonomi">Ekonomi</option>
                        <option value="Olahraga">Olahraga</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>URL Gambar (atau nama file)</label>
                    <input type="file" name="gambar" class="form-control" placeholder="contoh: berita1.jpg">
                </div>
                <div class="mb-3">
                    <label>Ringkasan Berita</label>
                    <textarea name="ringkasan" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Isi Lengkap Berita</label>
                    <textarea name="isi" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Simpan Berita</button>
                <a href="home_admin.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>

</html>