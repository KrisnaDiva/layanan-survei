<?php
$title = "Home";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';

$koneksi = getKoneksi();

$sql = "SELECT * FROM indikator";
$statement = $koneksi->prepare($sql);
$statement->execute();
$indikator = $statement->fetchAll();
?>
<section id="hero" class="hero section">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                <h1>Berikan Tanggapan Terhadap Layanan Pada </h1>
                <h6>Prodi D3 Manajemen Informatika & Komputerisasi Akuntansi</h6>
                <div class="d-flex">
                    <a href="#services" class="btn btn-primary px-4 py-2">Isi Survei</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="services" class="services section">
    <div class="container section-title" data-aos="fade-up">
        <p><span>Layanan</span> <span class="description-title">Survei</span></p>
        <?php
        $sql = "SELECT * FROM jawaban WHERE user_id = ?";
        $statement = $koneksi->prepare($sql);
        $statement->execute([$_SESSION['user_id']]);
        $jawaban = $statement->fetchAll();

        if (count($jawaban) == 24) {
            echo "<small>Terima Kasih Atas Partisipasi Anda Dalam Mengisi Survei</small>";
        }
        ?>
    </div>
    <div class="container">
        <div class="row gy-4">
            <?php foreach ($indikator as $value): ?>
                <div class="col-3">
                    <div class="service-item position-relative">
                        <div class="member-img">
                            <img src="../../landing/assets/img/<?= $value['indikator'] ?>.jpg" class="card-img-top border" alt="...">
                        </div>
                        <h5 class="mt-3"><?= $value['indikator'] ?></h5>
                        <p style="text-transform: capitalize">
                            Dengan mengisi survei ini, Anda membantu kami dalam memahami kelebihan dan kekurangan yang
                            ada dalam <?= $value['indikator'] ?>
                        </p>
                        <?php
                        $sql = "SELECT * FROM jawaban WHERE user_id = ? AND indikator_id = ?";
                        $statement = $koneksi->prepare($sql);
                        $statement->execute([$_SESSION['user_id'], $value['id']]);
                        $jawaban = $statement->fetch();
                        ?>
                        <?php if ($jawaban) : ?>
                            <button class="btn btn-success w-100 mt-4" disabled>Sudah Diisi</button>
                        <?php else : ?>
                            <a href="survei.php?id=<?= $value['id'] ?>" class="btn btn-primary w-100 mt-4">Survei
                                Sekarang</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include("template.php");
?>
