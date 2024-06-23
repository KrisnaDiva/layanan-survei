<?php
require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $koneksi = getKoneksi();

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);
    $user = $statement->fetch();

    if($user['role'] == 'admin') {
        echo "<script type='text/javascript'>
            alert('Mahasiswa gagal dihapus');
                window.location.href = '../tampilan/admin/data_mahasiswa.php';
        </script>";
        exit();
    }

    $sql = "DELETE FROM users WHERE user_id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Mahasiswa berhasil dihapus.');
                window.location.href = '../tampilan/admin/data_mahasiswa.php';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Mahasiswa gagal dihapus');
                window.location.href = '../tampilan/admin/data_mahasiswa.php';
        </script>";
    }
}
$koneksi = null;