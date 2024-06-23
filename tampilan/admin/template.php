<?php
require_once __DIR__ . '/../../middleware.php';
require_once __DIR__ . '/../../koneksi.php';

auth();
$koneksi = getKoneksi();

$sql = "SELECT * FROM users WHERE user_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['user_id']]);
$user = $statement->fetch();

$sql = "SELECT * FROM indikator";
$statement = $koneksi->prepare($sql);
$statement->execute();
$indikator = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>  <?= $title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../../assets/css/ready.css">
    <link rel="stylesheet" href="../../assets/css/demo.css">
    <link rel="stylesheet"
          href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        .sidebar .nav {
            margin-top: 0;
        }

    </style>
</head>
<body>
<div class="wrapper">
    <div class="main-header">
        <div class="logo-header">
            <a href="index.php" class="logo">
                Survei
            </a>
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
        </div>
        <nav class="navbar navbar-header navbar-expand-lg">
            <div class="container-fluid">

                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                            <img src="../../assets/img/profile.png"
                                 alt="user-img" width="36"
                                 class="img-circle border"><span><?= $user['nama'] ?></span></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user" style="left: 0">
                            <a class="dropdown-item" href="../../proses/logout.php"><i
                                        class="fa fa-power-off"></i> Logout</a>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="sidebar">
        <div class="scrollbar-inner sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item <?= basename($_SERVER['PHP_SELF'], '.php') == 'index' ? 'active' : ''; ?>">
                    <a href="index.php">
                        <i class="la la-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
            <div class="dropdown-divider"></div>
            <p style="color: black; text-align: center">Data Mahasiswa</p>
            <ul class="nav">
                <li class="nav-item <?= basename($_SERVER['PHP_SELF'], '.php') == 'data_mahasiswa' ? 'active' : ''; ?>">
                    <a href="data_mahasiswa.php">
                        <i class="la la-user"></i>
                        <span>Cek Data Mahasiswa</span>
                    </a>
                </li>
            </ul>
            <div class="dropdown-divider"></div>
            <p style="color: black; text-align: center">Data Survei MI</p>
            <ul class="nav">
                <?php foreach ($indikator as $value): ?>
                <li class="nav-item <?= basename($_SERVER['PHP_SELF'], '.php') == '' ? 'active' : ''; ?>">
                    <a href="grafik.php">
                        <i class="la la-user"></i>
                        <span><?= $value['indikator'] ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="dropdown-divider"></div>
            <p style="color: black; text-align: center">Data Survei MI</p>
            <ul class="nav">
                <?php foreach ($indikator as $value): ?>
                    <li class="nav-item <?= basename($_SERVER['PHP_SELF'], '.php') == '' ? 'active' : ''; ?>">
                        <a href="grafik.php">
                            <i class="la la-user"></i>
                            <span><?= $value['indikator'] ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <div class="content">
            <?= $content; ?>
        </div>
    </div>
</div>
</body>
<script src="../../assets/js/core/jquery.3.2.1.min.js"></script>
<script src="../../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugin/chartist/chartist.min.js"></script>
<script src="../../assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="../../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="../../assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="../../assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="../../assets/js/ready.min.js"></script>
<script src="../../assets/js/demo.js"></script>
</html>