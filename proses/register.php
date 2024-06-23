<?php
require_once __DIR__ . '/../koneksi.php';

$koneksi = getKoneksi();
$data = [
    'nama' => $_POST['nama'],
    'npm' => $_POST['npm'],
    'fakultas' => $_POST['fakultas'],
    'prodi' => $_POST['prodi'],
    'email' => $_POST['email'],
    'username' => $_POST['username'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
];

$stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data['email']]);
if ($stmt->rowCount() > 0) {
    echo "<script type='text/javascript'>
        alert('Registrasi gagal, Email sudah terdaftar.');
        window.location.href = '../tampilan/register.php';
      </script>";
    exit();
}

$stmt = $koneksi->prepare("SELECT * FROM users WHERE npm = ?");
$stmt->execute([$data['npm']]);
if ($stmt->rowCount() > 0) {
    echo "<script type='text/javascript'>
        alert('Registrasi gagal, NPM sudah terdaftar.');
        window.location.href = '../tampilan/register.php';
      </script>";
    exit();
}

$stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$data['username']]);
if ($stmt->rowCount() > 0) {
    echo "<script type='text/javascript'>
        alert('Registrasi gagal, Username sudah terdaftar.');
        window.location.href = '../tampilan/register.php';
      </script>";
    exit();
}

$placeholders = str_repeat('?,', count($data) - 1) . '?';
$fields = implode(',', array_keys($data));
$stmt = $koneksi->prepare("INSERT INTO users ($fields) VALUES ($placeholders)");

if ($stmt->execute(array_values($data))) {
    echo "<script type='text/javascript'>
            alert('Registrasi berhasil.');
            window.location.href = '../tampilan/login.php';
          </script>";
} else {
    echo "<script type='text/javascript'>
        alert('`{${$stmt->errorInfo()[2]}}`');
            window.location.href = '../tampilan/register.php';
      </script>";
}
$koneksi = null;