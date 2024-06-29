<?php
require_once __DIR__ . '/../middleware.php';
guest();
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../admin/assets/images/favicon.ico" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="../admin/assets/css/core/libs.min.css" />


    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="../admin/assets/css/hope-ui.min.css?v=2.0.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="../admin/assets/css/custom.min.css?v=2.0.0" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="../admin/assets/css/dark.min.css"/>

    <!-- Customizer Css -->
    <link rel="stylesheet" href="../admin/assets/css/customizer.min.css" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="../admin/assets/css/rtl.min.css"/>

</head>
<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
<!-- loader Start -->
<div id="loading">
    <div class="loader simple-loader">
        <div class="loader-body"></div>
    </div>    </div>
<!-- loader END -->

<div class="wrapper">
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                            <div class="card-body">
                                <h2 class="mb-2 text-center">Login</h2>
                                <p class="text-center">Login untuk masuk ke survei.</p>
                                <form method="post" action="../proses/login.php">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="mb-2 text-muted" for="username">NPM</label>
                                                <input id="npm" type="text" class="form-control" name="npm" required>                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="mb-2 text-muted" for="password">Password</label>
                                                <input id="password" type="password" class="form-control" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                    <p class="mt-3 text-center">
                                        Belum punya akun? <a href="register.php" class="text-underline">Register.</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                <img src="../admin/assets/images/auth/01.png" class="img-fluid gradient-main animated-scaleX" alt="images">
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
<script src="../admin/assets/js/charts/dashboard.js" ></script>

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