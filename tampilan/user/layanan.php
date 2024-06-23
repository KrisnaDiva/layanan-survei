<?php
$title = "Layanan";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM indikator";
$statement = $koneksi->prepare($sql);
$statement->execute();
$indikator = $statement->fetchAll();

?>
<div class="row justify-content-center mb-3">
    <div class="card text-center">
        <div class="card-body">
            <h3 class="card-title">Layanan Survei</h3>
            <div class="row mt-5">
                <?php foreach ($indikator as $value): ?>
                    <div class="col-3">
                        <div class="card">
                            <img src="../../assets/img/profile.png" class="card-img-top border" alt="...">
                            <div class="card-body">
                                <h5 class="card-text"><?= $value['indikator'] ?></h5>
                                <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                    do
                                    eiusmod tempor </small>
                            </div>
                            <div class="card-footer">
                                <?php
                                $sql = "SELECT * FROM jawaban WHERE user_id = ? AND indikator_id = ?";
                                $statement = $koneksi->prepare($sql);
                                $statement->execute([$_SESSION['user_id'], $value['id']]);
                                $jawaban = $statement->fetch();
                                ?>
                                <?php if ($jawaban) : ?>
                                    <button class="btn btn-success" disabled>Sudah Diisi</button>
                                <?php else : ?>
                                <a href="survei.php?id=<?= $value['id'] ?>" class="btn btn-primary" >Survei Sekarang</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("template.php");
?>
