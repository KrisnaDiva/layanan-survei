<?php
$title = "Edit Survei";
ob_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();

$id = $_GET['id'];
$prodi_param = $_GET['prodi'];
$indikator_param = $_GET['indikator'];

$sql = "SELECT * FROM jawaban WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$jawaban = $statement->fetch();

if(!$jawaban){
    header('Location: data_survei.php?indikator='.$indikator_param.'&prodi='.$prodi_param);
    exit;
}

$indikator_id = $jawaban['indikator_id'];
$user_id = $jawaban['user_id'];
$pilihan_id = $jawaban['pilihan_id'];
$pertanyaan_id = $jawaban['pertanyaan_id'];

$sql = "SELECT nama FROM users WHERE user_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$user_id]);
$user = $statement->fetch();

$sql = "SELECT indikator FROM indikator WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$indikator_id]);
$indikator = $statement->fetchColumn();

$sql = "SELECT pertanyaan FROM pertanyaan WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$pertanyaan_id]);
$pertanyaan = $statement->fetchColumn();
?>

<div class="row justify-content-center mb-3">
    <div class="col-md-8">
        <div class="card">
            <form action="../../proses/ubah_survei.php" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="indikator_param" value="<?= $indikator_param ?>">
                <input type="hidden" name="prodi_param" value="<?= $prodi_param ?>">
                <div class="card-header">
                    <div class="card-title">Edit Survei</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?= $user['nama'] ?>"
                                       placeholder="Masukkan nama" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="indikator">Indikator</label>
                                <input type="text" class="form-control" name="indikator" value="<?= $indikator ?>"
                                       placeholder="Masukkan Indikator" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="text" class="form-control" name="pertanyaan" value="<?= $pertanyaan ?>"
                                       placeholder="Masukkan pertanyaan" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pilihan">Pilihan</label>
                                <select class="form-control" aria-label="Default select example" name="pilihan_id" required>
                                    <option selected value="">Pilih pilihan</option>
                                    <?php
                                    $sql = "SELECT * FROM pilihan";
                                    $statement = $koneksi->prepare($sql);
                                    $statement->execute();
                                    $pilihan = $statement->fetchAll();
                                    ?>
                                    <?php foreach ($pilihan as $item): ?>
                                        <option value="<?= $item['id'] ?>" <?= $pilihan_id == $item['id'] ? 'selected' : ''; ?>>
                                            <?= $item['pilihan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-action text-right">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>
