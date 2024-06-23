<?php
session_start();

session_destroy();
header("Location: ../tampilan/login.php");
