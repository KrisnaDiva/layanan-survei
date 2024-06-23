<?php
function guest(): void
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_id']) && $_SESSION['login']) {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
            header("Location: user/index.php");
            exit();
        }
        header("Location: admin/index.php");
        exit();
    }
}

function auth(): void
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || !$_SESSION['login']) {
        header("Location: ../login.php");
        exit();
    }
}

function admin(): void
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SESSION['role'] != 'admin') {
        header("Location: ../login.php");
        exit();
    }
}

function user(): void
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SESSION['role'] != 'user') {
        header("Location: ../login.php");
        exit();
    }
}