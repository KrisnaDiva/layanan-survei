<?php
session_start();
require_once __DIR__ . '/../koneksi.php';
$koneksi = getKoneksi();
$postData = $_POST;

$indikator = $postData['indikator'];

try {
    $koneksi->beginTransaction();

    foreach ($postData as $key => $value) {
        if (strpos($key, 'pertanyaan') === 0) {
            $pertanyaan_id = str_replace('pertanyaan', '', $key);
            $pilihan_id = $value;

            $sql = "INSERT INTO jawaban (user_id, indikator_id, pertanyaan_id, pilihan_id) VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute([$_SESSION['user_id'], $indikator, $pertanyaan_id, $pilihan_id]);

        }
    }

    $koneksi->commit();

    echo "<script type='text/javascript'>
            alert('Survei Berhasil Diisi.');
            window.location.href = '../tampilan/user/layanan.php';
          </script>";
} catch (Exception $e) {
    $koneksi->rollBack();

    echo "<script type='text/javascript'>
        alert('`{${$e->getMessage()}}`');
            window.location.href = '../tampilan/user/survei.php?id=$indikator';
      </script>";
}
$koneksi = null;