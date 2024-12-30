<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Terlindungi</title>
</head>
<body>
    <h2>Selamat datang di halaman terlindungi!</h2>
    <p>Hanya pengguna yang sudah login yang dapat melihat halaman ini.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
