<?php
require_once __DIR__ . '/../../middleware.php';
require_once __DIR__ . '/../../koneksi.php';

auth();
admin();
$koneksi = getKoneksi();

$sql = "SELECT * FROM users WHERE user_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['user_id']]);
$user = $statement->fetch();

$sql = "SELECT * FROM indikator";
$statement = $koneksi->prepare($sql);
$statement->execute();
$indikator = $statement->fetchAll();

$sql = "SELECT DISTINCT prodi FROM users WHERE role = 'user'";
$statement = $koneksi->prepare($sql);
$statement->execute();
$prodi = $statement->fetchAll();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>  <?= $title; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../admin/assets/images/favicon.ico"/>

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="../../admin/assets/css/core/libs.min.css"/>

    <!-- Aos Animation Css -->
    <link rel="stylesheet" href="../../admin/assets/vendor/aos/dist/aos.css"/>

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="../../admin/assets/css/hope-ui.min.css?v=2.0.0"/>

    <!-- Custom Css -->
    <link rel="stylesheet" href="../../admin/assets/css/custom.min.css?v=2.0.0"/>

    <!-- Dark Css -->
    <link rel="stylesheet" href="../../admin/assets/css/dark.min.css"/>

    <!-- Customizer Css -->
    <link rel="stylesheet" href="../../admin/assets/css/customizer.min.css"/>

    <!-- RTL Css -->
    <link rel="stylesheet" href="../../admin/assets/css/rtl.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body class="  ">

<div id="loading">
    <div class="loader simple-loader">
        <div class="loader-body"></div>
    </div>
</div>

<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="index.php" class="navbar-brand">
            <h4 class="logo-title">Admin</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M4.25 12.2744L19.25 12.2744"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    <path
                            d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Home</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= in_array(basename($_SERVER['PHP_SELF'], '.php'), ['index']) ? 'active' : ''; ?>"
                       aria-current="page"
                       href="index.php">
                        <i class="icon">
                            <svg
                                    width="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon-20">
                                <path
                                        opacity="0.4"
                                        d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                                        fill="currentColor"></path>
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                                        fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>

                <?php foreach ($prodi as $row): ?>
                <li>
                    <hr class="hr-horizontal"/>
                </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon"><?= $row['prodi'] ?></span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                        <?php foreach ($indikator as $value): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF'], '.php'), ['data_survei', 'edit_survei']) && $_GET['indikator'] == $value['id'] && $_GET['prodi'] == $row['prodi']) ? 'active' : ''; ?>" href="data_survei.php?indikator=<?= $value['id'] ?>&prodi=<?= $row['prodi'] ?>">
                                    <i class="icon">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z" fill="currentColor"></path>
                                            <path d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z" fill="currentColor"></path>
                                            <path d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z" fill="currentColor"></path>
                                        </svg>
                                    </i>
                                    <span class="item-name"><?= $value['indikator'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                <?php endforeach; ?>
                <li>
                    <hr class="hr-horizontal"/>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>
<main class="main-content">
    <div class="position-relative iq-banner">
        <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
            <div class="container-fluid navbar-inner">
                <a href="index.php" class="navbar-brand">
                    <div class="logo-main">
                        <div class="logo-normal">
                            <svg
                                    class="text-primary icon-30"
                                    viewBox="0 0 30 30"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                <rect
                                        x="-0.757324"
                                        y="19.2427"
                                        width="28"
                                        height="4"
                                        rx="2"
                                        transform="rotate(-45 -0.757324 19.2427)"
                                        fill="currentColor"/>
                                <rect
                                        x="7.72803"
                                        y="27.728"
                                        width="28"
                                        height="4"
                                        rx="2"
                                        transform="rotate(-45 7.72803 27.728)"
                                        fill="currentColor"/>
                                <rect
                                        x="10.5366"
                                        y="16.3945"
                                        width="16"
                                        height="4"
                                        rx="2"
                                        transform="rotate(45 10.5366 16.3945)"
                                        fill="currentColor"/>
                                <rect
                                        x="10.5562"
                                        y="-0.556152"
                                        width="28"
                                        height="4"
                                        rx="2"
                                        transform="rotate(45 10.5562 -0.556152)"
                                        fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="logo-mini">
                            <svg
                                    class="text-primary icon-30"
                                    viewBox="0 0 30 30"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                <rect
                                        x="-0.757324"
                                        y="19.2427"
                                        width="28"
                                        height="4"
                                        rx="2"
                                        transform="rotate(-45 -0.757324 19.2427)"
                                        fill="currentColor"/>
                                <rect
                                        x="7.72803"
                                        y="27.728"
                                        width="28"
                                        height="4"
                                        rx="2"
                                        transform="rotate(-45 7.72803 27.728)"
                                        fill="currentColor"/>
                                <rect
                                        x="10.5366"
                                        y="16.3945"
                                        width="16"
                                        height="4"
                                        rx="2"
                                        transform="rotate(45 10.5366 16.3945)"
                                        fill="currentColor"/>
                                <rect
                                        x="10.5562"
                                        y="-0.556152"
                                        width="28"
                                        height="4"
                                        rx="2"
                                        transform="rotate(45 10.5562 -0.556152)"
                                        fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <h4 class="logo-title">Hope UI</h4>
                </a>
                <div
                        class="sidebar-toggle"
                        data-toggle="sidebar"
                        data-active="true">
                    <i class="icon">
                        <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                            <path
                                    fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"/>
                        </svg>
                    </i>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul
                            class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                        <li class="nav-item dropdown">
                            <a
                                    class="py-0 nav-link d-flex align-items-center"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <img
                                        src="../../admin/assets/images/avatars/01.png"
                                        alt="User-Profile"
                                        class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded"/>
                                <img
                                        src="../../admin/assets/images/avatars/avtar_1.png"
                                        alt="User-Profile"
                                        class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded"/>
                                <img
                                        src="../../admin/assets/images/avatars/avtar_2.png"
                                        alt="User-Profile"
                                        class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded"/>
                                <img
                                        src="../../admin/assets/images/avatars/avtar_4.png"
                                        alt="User-Profile"
                                        class="theme-color-green-img img-fluid avatar avatar-50 avatar-rounded"/>
                                <img
                                        src="../../admin/assets/images/avatars/avtar_5.png"
                                        alt="User-Profile"
                                        class="theme-color-yellow-img img-fluid avatar avatar-50 avatar-rounded"/>
                                <img
                                        src="../../admin/assets/images/avatars/avtar_3.png"
                                        alt="User-Profile"
                                        class="theme-color-pink-img img-fluid avatar avatar-50 avatar-rounded"/>
                                <div class="caption ms-3 d-none d-md-block">
                                    <h6 class="mb-0 caption-title"><?= $user['username'] ?></h6>
                                </div>
                            </a>
                            <ul
                                    class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item"
                                       href="../../proses/logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="iq-navbar-header" style="height: 75px"></div>
    </div>

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <?= $content; ?>
    </div>

    <footer class="footer">
        <div class="footer-body">
            <ul class="left-panel list-inline mb-0 p-0"></ul>
            <div class="right-panel">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                Layanan Kebersihan
            </div>
        </div>
    </footer>
</main>
<div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="offcanvasExample"
        data-bs-scroll="true"
        data-bs-backdrop="true"
        aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="d-flex align-items-center">
            <h3 class="offcanvas-title me-3" id="offcanvasExampleLabel">
                Settings
            </h3>
        </div>
        <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body data-scrollbar">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="mb-3">Scheme</h5>
                <div class="d-grid gap-3 grid-cols-3 mb-4">
                    <div
                            class="btn btn-border"
                            data-setting="color-mode"
                            data-name="color"
                            data-value="auto">
                        <svg
                                class="icon-20"
                                width="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                    fill="currentColor"
                                    d="M7,2V13H10V22L17,10H13L17,2H7Z"/>
                        </svg>
                        <span class="ms-2"> Auto </span>
                    </div>

                    <div
                            class="btn btn-border"
                            data-setting="color-mode"
                            data-name="color"
                            data-value="dark">
                        <svg
                                class="icon-20"
                                width="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                    fill="currentColor"
                                    d="M9,2C7.95,2 6.95,2.16 6,2.46C10.06,3.73 13,7.5 13,12C13,16.5 10.06,20.27 6,21.54C6.95,21.84 7.95,22 9,22A10,10 0 0,0 19,12A10,10 0 0,0 9,2Z"/>
                        </svg>
                        <span class="ms-2"> Dark </span>
                    </div>
                    <div
                            class="btn btn-border active"
                            data-setting="color-mode"
                            data-name="color"
                            data-value="light">
                        <svg
                                class="icon-20"
                                width="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                    fill="currentColor"
                                    d="M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z"/>
                        </svg>
                        <span class="ms-2"> Light</span>
                    </div>
                </div>
                <hr class="hr-horizontal"/>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mt-4 mb-3">Color Customizer</h5>
                    <button
                            class="btn btn-transparent p-0 border-0"
                            data-value="theme-color-default"
                            data-info="#079aa2"
                            data-setting="color-mode1"
                            data-name="color"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title=""
                            data-bs-original-title="Default">
                        <svg
                                class="icon-18"
                                width="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M21.4799 12.2424C21.7557 12.2326 21.9886 12.4482 21.9852 12.7241C21.9595 14.8075 21.2975 16.8392 20.0799 18.5506C18.7652 20.3986 16.8748 21.7718 14.6964 22.4612C12.518 23.1505 10.1711 23.1183 8.01299 22.3694C5.85488 21.6205 4.00382 20.196 2.74167 18.3126C1.47952 16.4293 0.875433 14.1905 1.02139 11.937C1.16734 9.68346 2.05534 7.53876 3.55018 5.82945C5.04501 4.12014 7.06478 2.93987 9.30193 2.46835C11.5391 1.99683 13.8711 2.2599 15.9428 3.2175L16.7558 1.91838C16.9822 1.55679 17.5282 1.62643 17.6565 2.03324L18.8635 5.85986C18.945 6.11851 18.8055 6.39505 18.549 6.48314L14.6564 7.82007C14.2314 7.96603 13.8445 7.52091 14.0483 7.12042L14.6828 5.87345C13.1977 5.18699 11.526 4.9984 9.92231 5.33642C8.31859 5.67443 6.8707 6.52052 5.79911 7.74586C4.72753 8.97119 4.09095 10.5086 3.98633 12.1241C3.8817 13.7395 4.31474 15.3445 5.21953 16.6945C6.12431 18.0446 7.45126 19.0658 8.99832 19.6027C10.5454 20.1395 12.2278 20.1626 13.7894 19.6684C15.351 19.1743 16.7062 18.1899 17.6486 16.8652C18.4937 15.6773 18.9654 14.2742 19.0113 12.8307C19.0201 12.5545 19.2341 12.3223 19.5103 12.3125L21.4799 12.2424Z"
                                    fill="#31BAF1"/>
                            <path
                                    d="M20.0941 18.5594C21.3117 16.848 21.9736 14.8163 21.9993 12.7329C22.0027 12.4569 21.7699 12.2413 21.4941 12.2512L19.5244 12.3213C19.2482 12.3311 19.0342 12.5633 19.0254 12.8395C18.9796 14.283 18.5078 15.6861 17.6628 16.8739C16.7203 18.1986 15.3651 19.183 13.8035 19.6772C12.2419 20.1714 10.5595 20.1483 9.01246 19.6114C7.4654 19.0746 6.13845 18.0534 5.23367 16.7033C4.66562 15.8557 4.28352 14.9076 4.10367 13.9196C4.00935 18.0934 6.49194 21.37 10.008 22.6416C10.697 22.8908 11.4336 22.9852 12.1652 22.9465C13.075 22.8983 13.8508 22.742 14.7105 22.4699C16.8889 21.7805 18.7794 20.4073 20.0941 18.5594Z"
                                    fill="#0169CA"/>
                        </svg>
                    </button>
                </div>
                <div class="grid-cols-5 mb-4 d-grid gap-x-2">
                    <div
                            class="btn btn-border bg-transparent"
                            data-value="theme-color-blue"
                            data-info="#573BFF"
                            data-setting="color-mode1"
                            data-name="color"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title=""
                            data-bs-original-title="Theme-1">
                        <svg
                                class="customizer-btn icon-32"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="32">
                            <circle cx="12" cy="12" r="10" fill="#00C3F9"/>
                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#573BFF"/>
                        </svg>
                    </div>
                    <div
                            class="btn btn-border bg-transparent"
                            data-value="theme-color-gray"
                            data-info="#FD8D00"
                            data-setting="color-mode1"
                            data-name="color"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title=""
                            data-bs-original-title="Theme-2">
                        <svg
                                class="customizer-btn icon-32"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="32">
                            <circle cx="12" cy="12" r="10" fill="#91969E"/>
                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#FD8D00"/>
                        </svg>
                    </div>
                    <div
                            class="btn btn-border bg-transparent"
                            data-value="theme-color-red"
                            data-info="#366AF0"
                            data-setting="color-mode1"
                            data-name="color"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title=""
                            data-bs-original-title="Theme-3">
                        <svg
                                class="customizer-btn icon-32"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="32">
                            <circle cx="12" cy="12" r="10" fill="#DB5363"/>
                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#366AF0"/>
                        </svg>
                    </div>
                    <div
                            class="btn btn-border bg-transparent"
                            data-value="theme-color-yellow"
                            data-info="#6410F1"
                            data-setting="color-mode1"
                            data-name="color"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title=""
                            data-bs-original-title="Theme-4">
                        <svg
                                class="customizer-btn icon-32"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="32">
                            <circle cx="12" cy="12" r="10" fill="#EA6A12"/>
                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#6410F1"/>
                        </svg>
                    </div>
                    <div
                            class="btn btn-border bg-transparent"
                            data-value="theme-color-pink"
                            data-info="#25C799"
                            data-setting="color-mode1"
                            data-name="color"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title=""
                            data-bs-original-title="Theme-5">
                        <svg
                                class="customizer-btn icon-32"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="32">
                            <circle cx="12" cy="12" r="10" fill="#E586B3"/>
                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#25C799"/>
                        </svg>
                    </div>
                </div>
                <hr class="hr-horizontal"/>
                <h5 class="mb-3 mt-4">Scheme Direction</h5>
                <div class="d-grid gap-3 grid-cols-2 mb-4">
                    <div class="text-center">
                        <img src="../../admin/assets/images/settings/dark/01.png"
                             alt="ltr"
                             class="mode dark-img img-fluid btn-border p-0 flex-column active mb-2"
                             data-setting="dir-mode"
                             data-name="dir"
                             data-value="ltr"/>
                        <img src="../../admin/assets/images/settings/light/01.png"
                             alt="ltr"
                             class="mode light-img img-fluid btn-border p-0 flex-column active mb-2"
                             data-setting="dir-mode"
                             data-name="dir"
                             data-value="ltr"/>
                        <span class="mt-2"> LTR </span>
                    </div>
                    <div class="text-center">
                        <img src="../../admin/assets/images/settings/dark/02.png"
                             alt=""
                             class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                             data-setting="dir-mode"
                             data-name="dir"
                             data-value="rtl"/>
                        <img src="../../admin/assets/images/settings/light/02.png"
                             alt=""
                             class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                             data-setting="dir-mode"
                             data-name="dir"
                             data-value="rtl"/>
                        <span class="mt-2"> RTL </span>
                    </div>
                </div>
                <hr class="hr-horizontal"/>
                <h5 class="mt-4 mb-3">Sidebar Color</h5>
                <div class="d-grid gap-3 grid-cols-2 mb-4">
                    <div
                            class="btn btn-border d-block"
                            data-setting="sidebar"
                            data-name="sidebar-color"
                            data-value="sidebar-white">
                        <span class=""> Default </span>
                    </div>
                    <div
                            class="btn btn-border d-block"
                            data-setting="sidebar"
                            data-name="sidebar-color"
                            data-value="sidebar-dark">
                        <span class=""> Dark </span>
                    </div>
                    <div
                            class="btn btn-border d-block"
                            data-setting="sidebar"
                            data-name="sidebar-color"
                            data-value="sidebar-color">
                        <span class=""> Color </span>
                    </div>

                    <div
                            class="btn btn-border d-block"
                            data-setting="sidebar"
                            data-name="sidebar-color"
                            data-value="sidebar-transparent">
                        <span class=""> Transparent </span>
                    </div>
                </div>
                <hr class="hr-horizontal"/>
                <h5 class="mt-4 mb-3">Sidebar Types</h5>
                <div class="d-grid gap-3 grid-cols-3 mb-4">
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/03.png"
                                alt="mini"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-type"
                                data-value="sidebar-mini"/>
                        <img
                                src="../../admin/assets/images/settings/light/03.png"
                                alt="mini"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-type"
                                data-value="sidebar-mini"/>
                        <span class="mt-2">Mini</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/04.png"
                                alt="hover"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-type"
                                data-value="sidebar-hover"
                                data-extra-value="sidebar-mini"/>
                        <img
                                src="../../admin/assets/images/settings/light/04.png"
                                alt="hover"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-type"
                                data-value="sidebar-hover"
                                data-extra-value="sidebar-mini"/>
                        <span class="mt-2">Hover</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/05.png"
                                alt="boxed"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-type"
                                data-value="sidebar-boxed"/>
                        <img
                                src="../../admin/assets/images/settings/light/05.png"
                                alt="boxed"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-type"
                                data-value="sidebar-boxed"/>
                        <span class="mt-2">Boxed</span>
                    </div>
                </div>
                <hr class="hr-horizontal"/>
                <h5 class="mt-4 mb-3">Sidebar Active Style</h5>
                <div class="d-grid gap-3 grid-cols-2 mb-4">
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/06.png"
                                alt="rounded-one-side"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-rounded"/>
                        <img
                                src="../../admin/assets/images/settings/light/06.png"
                                alt="rounded-one-side"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-rounded"/>
                        <span class="mt-2">Rounded One Side</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/07.png"
                                alt="rounded-all"
                                class="mode dark-img img-fluid btn-border p-0 flex-column active mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-rounded-all"/>
                        <img
                                src="../../admin/assets/images/settings/light/07.png"
                                alt="rounded-all"
                                class="mode light-img img-fluid btn-border p-0 flex-column active mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-rounded-all"/>
                        <span class="mt-2">Rounded All</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/08.png"
                                alt="pill-one-side"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-pill"/>
                        <img
                                src="../../admin/assets/images/settings/light/09.png"
                                alt="pill-one-side"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-pill"/>
                        <span class="mt-2">Pill One Side</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/09.png"
                                alt="pill-all"
                                class="mode dark-img img-fluid btn-border p-0 flex-column"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-pill-all"/>
                        <img
                                src="../../admin/assets/images/settings/light/08.png"
                                alt="pill-all"
                                class="mode light-img img-fluid btn-border p-0 flex-column"
                                data-setting="sidebar"
                                data-name="sidebar-item"
                                data-value="navs-pill-all"/>
                        <span class="mt-2">Pill All</span>
                    </div>
                </div>
                <hr class="hr-horizontal"/>
                <h5 class="mt-4 mb-3">Navbar Style</h5>
                <div class="d-grid gap-3 grid-cols-2">
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/11.png"
                                alt="image"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar"
                                data-name="navbar-type"
                                data-value="nav-glass"/>
                        <img
                                src="../../admin/assets/images/settings/light/10.png"
                                alt="image"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar"
                                data-name="navbar-type"
                                data-value="nav-glass"/>
                        <span class="mt-2">Glass</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/10.png"
                                alt="color"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar-header"
                                data-name="navbar-type"
                                data-value="navs-bg-color"/>
                        <img
                                src="../../admin/assets/images/settings/light/11.png"
                                alt="color"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar-header"
                                data-name="navbar-type"
                                data-value="navs-bg-color"/>
                        <span class="mt-2">Color</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/12.png"
                                alt="sticky"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar"
                                data-name="navbar-type"
                                data-value="navs-sticky"/>
                        <img
                                src="../../admin/assets/images/settings/light/12.png"
                                alt="sticky"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar"
                                data-name="navbar-type"
                                data-value="navs-sticky"/>
                        <span class="mt-2">Sticky</span>
                    </div>
                    <div class="text-center">
                        <img
                                src="../../admin/assets/images/settings/dark/13.png"
                                alt="transparent"
                                class="mode dark-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar"
                                data-name="navbar-type"
                                data-value="navs-transparent"/>
                        <img
                                src="../../admin/assets/images/settings/light/13.png"
                                alt="transparent"
                                class="mode light-img img-fluid btn-border p-0 flex-column mb-2"
                                data-setting="navbar"
                                data-target=".iq-navbar"
                                data-name="navbar-type"
                                data-value="navs-transparent"/>
                        <span class="mt-2">Transparent</span>
                    </div>
                    <div
                            class="btn btn-border active col-span-full mt-4 d-block"
                            data-setting="navbar"
                            data-name="navbar-default"
                            data-value="default">
                        <span class=""> Default Navbar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Library Bundle Script -->
<script src="../../admin/assets/js/core/libs.min.js"></script>

<!-- External Library Bundle Script -->
<script src="../../admin/assets/js/core/external.min.js"></script>

<!-- Widgetchart Script -->
<script src="../../admin/assets/js/charts/widgetcharts.js"></script>

<!-- mapchart Script -->
<script src="../../admin/assets/js/charts/vectore-chart.js"></script>
<script src="../../admin/assets/js/charts/dashboard.js"></script>

<!-- fslightbox Script -->
<script src="../../admin/assets/js/plugins/fslightbox.js"></script>

<!-- Settings Script -->
<script src="../../admin/assets/js/plugins/setting.js"></script>

<!-- Slider-tab Script -->
<script src="../../admin/assets/js/plugins/slider-tabs.js"></script>

<!-- Form Wizard Script -->
<script src="../../admin/assets/js/plugins/form-wizard.js"></script>

<!-- AOS Animation Plugin-->
<script src="../../admin/assets/vendor/aos/dist/aos.js"></script>

<!-- App Script -->
<script src="../../admin/assets/js/hope-ui.js" defer></script>
</body>
</html>
