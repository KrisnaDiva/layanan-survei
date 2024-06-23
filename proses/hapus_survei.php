<?php
require_once __DIR__ . "/../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $prodi_param = $_POST['prodi_param'];
    $indikator_param = $_POST['indikator_param'];

    $koneksi = getKoneksi();


    $sql = "DELETE FROM jawaban WHERE id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);

    if ($statement->rowCount() > 0) {
        echo "<script type='text/javascript'>
            alert('Survei berhasil dihapus.');
                 window.location.href = '../tampilan/admin/data_survei.php?indikator=$indikator_param&prodi=$prodi_param';
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Survei gagal dihapus');
                 window.location.href = '../tampilan/admin/data_survei.php?indikator=$indikator_param&prodi=$prodi_param';
        </script>";
    }
}
$koneksi = null;