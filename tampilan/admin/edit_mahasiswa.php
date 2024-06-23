<?php
$title = "Edit Mahasiswa";
ob_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$mahasiswa = $statement->fetch();

$nama = $mahasiswa['nama'];
$npm = $mahasiswa['npm'];
$fakultas = $mahasiswa['fakultas'];
$prodi = $mahasiswa['prodi'];
$email = $mahasiswa['email'];
$username = $mahasiswa['username'];
$role = $mahasiswa['role'];

if ($role == 'admin') {
    header('Location: data_mahasiswa.php');
    exit();
}
?>

<div class="row justify-content-center mb-3">
    <div class="col-md-8">
        <div class="card">
            <form action="../../proses/ubah_mahasiswa.php" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="card-header">
                    <div class="card-title">Edit Mahasiswa</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?= $nama ?>"
                                       placeholder="Masukkan nama" required>
                            </div>
                            <div class="form-group">
                                <label for="npm">NPM</label>
                                <input type="text" class="form-control" name="npm" value="<?= $npm ?>"
                                       placeholder="Masukkan NPM" required>
                            </div>
                            <div class="form-group">
                                <label for="fakultas" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" name="fakultas" value="<?= $fakultas ?>"
                                       placeholder="Masukkan fakultas" required readonly>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $email ?>"
                                       placeholder="Masukkan email" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" value="<?= $username ?>"
                                       placeholder="Masukkan username" required>
                            </div>
                            <div class="form-group">
                                <label for="prodi" class="form-label">Prodi</label>
                                <select class="form-control" aria-label="Default select example" name="prodi" required>
                                    <option selected value="">Pilih prodi</option>
                                    <option value="Komputerisasi Akutansi" <?= $prodi == 'Komputerisasi Akutansi' ? 'selected' : ''; ?>>
                                        Komputerisasi Akuntansi
                                    </option>
                                    <option value="Manajemen Informatika" <?= $prodi == 'Manajemen Informatika' ? 'selected' : ''; ?>>
                                        Manajemen Informatika
                                    </option>
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
