<?php
require_once __DIR__ . '/../middleware.php';
guest();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="row align-items-center justify-content-center" style="height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow-lg mb-5">
                <div class="card-header text-center">
                    <h1 class="fs-4 card-title fw-bold">Register</h1>
                </div>
                <div class="card-body p-4">
                    <form action="../proses/register.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="nama">Nama</label>
                                    <input id="nama" type="text" class="form-control" name="nama" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="npm">NPM</label>
                                    <input id="npm" type="number" class="form-control" name="npm" required>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="fakultas">Fakultas</label>
                                    <input id="fakultas" type="text" class="form-control" name="fakultas" value="Ekonomi" required readonly>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="username">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="prodi" class="form-label">Prodi</label>
                                    <select class="form-select" aria-label="Default select example" name="prodi"
                                            required>
                                        <option selected value="">Pilih prodi</option>
                                        <option value="Komputerisasi Akutansi">Komputerisasi Akutansi</option>
                                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required minlength="8">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer py-3 border-0">
                    <div class="text-center">
                        Sudah punya akun? <a href="login.php" class="text-dark">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>