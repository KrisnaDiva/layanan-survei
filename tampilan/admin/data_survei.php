<?php
$title = "Data Survei";
ob_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();
$indikator = $_GET['indikator'];
$prodi = $_GET['prodi'];


$sql = "SELECT jawaban.* FROM jawaban 
        JOIN users ON jawaban.user_id = users.user_id 
        WHERE jawaban.indikator_id = :indikator AND users.prodi = :prodi ";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':indikator', $indikator);
$statement->bindParam(':prodi', $prodi);
$statement->execute();
$result = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM jawaban 
        JOIN users ON jawaban.user_id = users.user_id 
        WHERE jawaban.indikator_id = :indikator AND users.prodi = :prodi";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':indikator', $indikator);
$statement->bindParam(':prodi', $prodi);
$statement->execute();
$total_rows = $statement->fetchColumn();

$sql = "SELECT indikator FROM indikator WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$indikator]);
$indikator_nama = $statement->fetchColumn();
?>

<div class="row justify-content-center mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?= $indikator_nama ?></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Pertanyaan</th>
                            <th>Pilihan</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody id="userTable">
                        <?php foreach ($result as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <?php
                                $sql = "SELECT nama FROM users WHERE user_id = ?";
                                $statement = $koneksi->prepare($sql);
                                $statement->execute([$value['user_id']]);
                                $user = $statement->fetch();
                                ?>
                                <td><?= $user['nama']; ?></td>
                                <?php
                                $sql = "SELECT pertanyaan FROM pertanyaan WHERE id = ?";
                                $statement = $koneksi->prepare($sql);
                                $statement->execute([$value['pertanyaan_id']]);
                                $pertanyaan = $statement->fetch();
                                ?>
                                <td><?= $pertanyaan['pertanyaan']; ?></td>
                                <?php
                                $sql = "SELECT pilihan FROM pilihan WHERE id = ?";
                                $statement = $koneksi->prepare($sql);
                                $statement->execute([$value['pilihan_id']]);
                                $pilihan = $statement->fetch();
                                ?>
                                <td><?= $pilihan['pilihan']; ?></td>
                                <td style="display: inline-block;">
                                    <a href="edit_survei.php?indikator=<?= $indikator ?>&prodi=<?= $prodi ?>&id=<?= $value['id'] ?>"
                                       class="btn btn-warning"
                                       style="display: inline-block;">Edit</a>
                                    <form method="POST" action="../../proses/hapus_survei.php"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus survei ini?');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                        <input type="hidden" name="indikator_param" value="<?= $indikator ?>">
                                        <input type="hidden" name="prodi_param" value="<?= $prodi ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include("template.php");
?>
