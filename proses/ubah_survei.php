<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();

$id = $_POST['id'];
$prodi_param = $_POST['prodi_param'];
$indikator_param = $_POST['indikator_param'];

$sql = "SELECT * FROM jawaban WHERE id = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$id]);
$jawaban = $statement->fetch();

if ($jawaban) {
    $data = [
        'pilihan_id' => $_POST['pilihan_id'],
    ];

    $fields = implode('=?,', array_keys($data)) . '=?';
    $stmt = $koneksi->prepare("UPDATE jawaban SET $fields WHERE id = $id");

    if ($stmt->execute(array_values($data))) {
        echo "<script type='text/javascript'>
                alert('Ubah jawaban berhasil.');
                 window.location.href = '../tampilan/admin/data_survei.php?indikator=$indikator_param&prodi=$prodi_param';
              </script>";
    }
} else {
    echo "<script type='text/javascript'>
        alert('Jawaban tidak ditemukan');
                 window.location.href = '../tampilan/admin/data_survei.php?indikator=$indikator_param&prodi=$prodi_param';
              </script>";
}