<?php
require_once __DIR__ . "/../koneksi.php";

$koneksi = getKoneksi();
$koneksi->beginTransaction();
try {
    $id = $_POST['id'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $statement = $koneksi->prepare($sql);
    $statement->execute([$id]);
    $user = $statement->fetch();

    if ($user['role'] == 'admin') {
        echo "<script type='text/javascript'>
            alert('Data mahasiswa gagal diubah');
                window.location.href = '../tampilan/admin/data_mahasiswa.php';
        </script>";
        exit();
    }

    $data = [
        'nama' => $_POST['nama'],
        'npm' => $_POST['npm'],
        'fakultas' => $_POST['fakultas'],
        'prodi' => $_POST['prodi'],
        'email' => $_POST['email'],
        'username' => $_POST['username'],
    ];

    if ($user['email'] != $data['email']) {
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->rowCount() > 0) {
            echo "<script type='text/javascript'>
        alert('Data mahasiswa gagal diubah, Email sudah terdaftar.');
        window.location.href = '../tampilan/admin/edit_mahasiswa.php?id=$id';
      </script>";
            exit();
        }
    }
    if ($user['npm'] != $data['npm']) {
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE npm = ?");
        $stmt->execute([$data['npm']]);
        if ($stmt->rowCount() > 0) {
            echo "<script type='text/javascript'>
        alert('Data mahasiswa gagal diubah, NPM sudah terdaftar.');
        window.location.href = '../tampilan/admin/edit_mahasiswa.php?id=$id';
      </script>";
            exit();
        }
    }

    if ($user['username'] != $data['username']) {
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$data['username']]);
        if ($stmt->rowCount() > 0) {
            echo "<script type='text/javascript'>
        alert('Data mahasiswa gagal diubah, Username sudah terdaftar.');
        window.location.href = '../tampilan/admin/edit_mahasiswa.php?id=$id';
      </script>";
            exit();
        }
    }

    $fields = implode('=?,', array_keys($data)) . '=?';
    $stmt = $koneksi->prepare("UPDATE users SET $fields WHERE user_id = $id");


    if ($stmt->execute(array_values($data))) {
        $koneksi->commit();
        echo "<script type='text/javascript'>
                alert('Ubah data mahasiswa berhasil.');
                window.location.href = '../tampilan/admin/data_mahasiswa.php';
              </script>";
        exit();
    }
} catch (Exception $e) {
    $koneksi->rollBack();

    $errorMessage = $e->getMessage();
    echo "<script type='text/javascript'>
        alert('Data mahasiswa gagal diubah $errorMessage');
        window.location.href = '../tampilan/admin/edit_mahasiswa.php?id=$id';
              </script>";
}
$koneksi = null;
