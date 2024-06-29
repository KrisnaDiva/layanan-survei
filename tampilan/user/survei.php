<?php
$title = "Survei";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();

if (!isset($_GET['id'])) {
    header('Location: layanan.php');
    exit;
}
$id = $_GET['id'];

$sql = "SELECT * FROM jawaban WHERE user_id = ? AND indikator_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$_SESSION['user_id'], $id]);
$jawaban = $statement->fetch();

if($jawaban) {
    header('Location: layanan.php');
    exit;
}

$sql = "SELECT * FROM indikator where id = $id";
$statement = $koneksi->prepare($sql);
$statement->execute();
$indikator = $statement->fetch();

$sql = "SELECT * FROM pertanyaan where indikator_id = $id";
$statement = $koneksi->prepare($sql);
$statement->execute();
$pertanyaan = $statement->fetchAll();

$sql = "SELECT * FROM pilihan";
$statement = $koneksi->prepare($sql);
$statement->execute();
$pilihan = $statement->fetchAll();
?>
<div class="row justify-content-center mb-3">
    <div class="card text-center">
        <div class="card-body">
            <h3 class="card-title"><?= $indikator['indikator'] ?></h3>
            <p class="card-text">Dengan mengisi survei ini, Anda membantu kami dalam memahami kelebihan dan kekurangan
                yang ada dalam <?= strtolower($indikator['indikator']) ?></p>
            <form method="POST" action="../../proses/simpan_survei.php">
                <div class="row mt-5 justify-content-center">
                    <input type="hidden" name="indikator" value="<?= $indikator['id'] ?>">
                    <?php foreach ($pertanyaan as $value): ?>
                        <div class="col-sm-5 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $value['pertanyaan'] ?></h5>
                                    <div class="btn-group-toggle mt-3" data-toggle="buttons">
                                        <?php foreach ($pilihan as $item): ?>
                                            <label class="btn btn-secondary">
                                                <input type="radio" name="pertanyaan<?= $value['id'] ?>" id="pertanyaan<?= $item['id'] ?>" value="<?= $item['id'] ?>" required>
                                                <?= $item['pilihan'] ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="mt-4 col-6 mx-auto">
                        <button class="btn btn-primary w-100" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-secondary input[type="radio"] {
        display: none;
    }

    .btn-secondary {
        background-color: #e9ecef;
        border-color: #e9ecef;
        color: #000;
    }

    .btn-secondary:hover {
        background-color: #d6d8db;
        border-color: #d6d8db;
        color: black;
    }

    .btn-secondary.active {
        background-color: #1d73b2;
        border-color: #0c5a91;
        color: #fff;
    }

    .btn-secondary.active:hover {
        background-color: #0c5a91;
        border-color: #004080;
    }
</style>

<script>
    document.querySelectorAll('.btn-group-toggle input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            let name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(input => {
                input.parentElement.classList.remove('active');
            });
            if (this.checked) {
                this.parentElement.classList.add('active');
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include("template.php");
?>
