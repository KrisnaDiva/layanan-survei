
<?php
require_once __DIR__ . '/../middleware.php';
guest();
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../admin/assets/images/favicon.ico"/>

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="../admin/assets/css/core/libs.min.css"/>


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="../admin/assets/css/hope-ui.min.css?v=2.0.0"/>

    <!-- Custom Css -->
    <link rel="stylesheet" href="../admin/assets/css/custom.min.css?v=2.0.0"/>

    <!-- Dark Css -->
    <link rel="stylesheet" href="../admin/assets/css/dark.min.css"/>

    <!-- Customizer Css -->
    <link rel="stylesheet" href="../admin/assets/css/customizer.min.css"/>

    <!-- RTL Css -->
    <link rel="stylesheet" href="../admin/assets/css/rtl.min.css"/>

</head>
<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
<!-- loader Start -->
<div id="loading">
    <div class="loader simple-loader">
        <div class="loader-body"></div>
    </div>
</div>
<!-- loader END -->

<div class="wrapper">
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white">
            <div class="col-md-5 d-md-block d-none bg-primary p-0 mt-n1 ">
                <img src="../admin/assets/images/auth/05.png" class="img-fluid gradient-main animated-scaleX"
                     alt="images">
            </div>
            <div class="col-md-7">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent  shadow-none d-flex justify-content-center mb-0">
                            <div class="card-body">
                                <h2 class="mb-2 text-center">Register</h2>
                                <p class="text-center">Buat akunmu untuk bergabung bersama kami.</p>
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
                                                <label class="mb-2 text-muted" for="password">Password</label>
                                                <input id="password" type="password" class="form-control" name="password" required minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                    <p class="mt-3 text-center">
                                        Sudah punya akun? <a href="login.php" class="text-underline">Login</a>
                                    </p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Library Bundle Script -->
<script src="../admin/assets/js/core/libs.min.js"></script>

<!-- External Library Bundle Script -->
<script src="../admin/assets/js/core/external.min.js"></script>

<!-- Widgetchart Script -->
<script src="../admin/assets/js/charts/widgetcharts.js"></script>

<!-- mapchart Script -->
<script src="../admin/assets/js/charts/vectore-chart.js"></script>
<script src="../admin/assets/js/charts/dashboard.js"></script>

<!-- fslightbox Script -->
<script src="../admin/assets/js/plugins/fslightbox.js"></script>

<!-- Settings Script -->
<script src="../admin/assets/js/plugins/setting.js"></script>

<!-- Slider-tab Script -->
<script src="../admin/assets/js/plugins/slider-tabs.js"></script>

<!-- Form Wizard Script -->
<script src="../admin/assets/js/plugins/form-wizard.js"></script>

<!-- AOS Animation Plugin-->

<!-- App Script -->
<script src="../admin/assets/js/hope-ui.js" defer></script>

</body>
</html>