<?php
require_once __DIR__ . '/../koneksi.php';

session_start();

$koneksi = getKoneksi();
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$statement = $koneksi->prepare($sql);
$statement->execute([$username]);

if ($row = $statement->fetch()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION["role"] = $row['role'];
        $_SESSION["login"] = true;

        if ($row['role'] === 'admin') {
            header("Location: ../tampilan/admin/index.php");
        } else {
            header("Location: ../tampilan/user/index.php");
        }
    } else {
        echo "<script type='text/javascript'>
        alert('Password salah.');
        window.location.href = '../tampilan/login.php';
      </script>";
    }
} else {
    echo "<script type='text/javascript'>
        alert('Username tidak ditemukan.');
        window.location.href = '../tampilan/login.php';
      </script>";
}
$koneksi = null;