<?php
$title = "Data Mahasiswa";
ob_start();

require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();

$sql = "SELECT * FROM users WHERE role = 'user'";
$statement = $koneksi->prepare($sql);
$statement->execute();
$users = $statement->fetchAll();
?>

<div class="row justify-content-center mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Mahasiswa</div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NPM</th>
                        <th>Fakultas</th>
                        <th>Prodi</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="userTable">
                    <?php foreach ($users as $key => $value): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value['nama']; ?></td>
                            <td><?= $value['npm']; ?></td>
                            <td><?= $value['fakultas']; ?></td>
                            <td><?= $value['prodi']; ?></td>
                            <td><?= $value['email']; ?></td>
                            <td><?= $value['username']; ?></td>
                            <td style="display: inline-block;">
                                <a href="edit_mahasiswa.php?id=<?= $value['user_id']; ?>" class="btn btn-warning"
                                   style="display: inline-block;">Edit</a>
                                <form method="POST" action="../../proses/hapus_mahasiswa.php"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');"
                                      style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?= $value['user_id']; ?>">
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
