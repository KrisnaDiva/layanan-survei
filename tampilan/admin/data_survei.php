<?php
$title = "Data Survei";
ob_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();
$indikator = $_GET['indikator'];
$prodi = $_GET['prodi'];

$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT jawaban.* FROM jawaban 
        JOIN users ON jawaban.user_id = users.user_id 
        WHERE jawaban.indikator_id = :indikator AND users.prodi = :prodi 
        LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':indikator', $indikator);
$statement->bindParam(':prodi', $prodi);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
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
$total_pages = ceil($total_rows / $limit);

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
            <div class="card-body text-right">
                <table class="table text-center">
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
                                <a href="edit_survei.php?indikator=<?= $indikator ?>&prodi=<?= $prodi ?>&id=<?= $value['id'] ?>" class="btn btn-warning"
                                   style="display: inline-block;"><i class="las la-edit"></i></a>
                                <form method="POST" action="../../proses/hapus_survei.php"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus survei ini?');"
                                      style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                    <input type="hidden" name="indikator_param" value="<?= $indikator ?>">
                                    <input type="hidden" name="prodi_param" value="<?= $prodi ?>">
                                    <button type="submit" class="btn btn-danger"><i class="las la-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <?php
                $entries_start = $offset + 1;
                $entries_end = $offset + count($result);
                $total_entries = $total_rows;

                echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1&indikator=<?= $indikator ?>&prodi=<?= urlencode($prodi) ?>">First</a>
        </li>
        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>&indikator=<?= $indikator ?>&prodi=<?= urlencode($prodi) ?>"><</a>
        </li>
        <?php
        $num_links_to_display = 2;
        $start = max(1, $page - $num_links_to_display);
        $end = min($total_pages, $page + $num_links_to_display);
        for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&indikator=<?= $indikator ?>&prodi=<?= urlencode($prodi) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>&indikator=<?= $indikator ?>&prodi=<?= urlencode($prodi) ?>">></a>
        </li>
        <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $total_pages ?>&indikator=<?= $indikator ?>&prodi=<?= urlencode($prodi) ?>">Last</a>
        </li>
    </ul>
</nav>            </div>

        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include("template.php");
?>
