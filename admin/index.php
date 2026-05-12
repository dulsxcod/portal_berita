<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            height: 100vh;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden;
        }

        .login-header {
            background: #dc3545;
            color: white;
            padding: 40px;
            text-align: center;
            font-weight: 800;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center fw-bold mb-4">ADMIN LOGIN</h3>
                        <form action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Login</button>
                            <a href="../index.php" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">Kembali ke Beranda</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>