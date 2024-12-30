<?php
session_start();
include('../../koneksi.php');

if (isset($_POST['presensi'])) {
    $nip = $_SESSION['nip'];
    $waktu = date('Y-m-d');
    $sql = "INSERT INTO presensi(nip, waktu) VALUES ($nip, '$waktu')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['pesan'] = "Anda telah presensi hari ini, Semangat Bekerja";
        header("Location: ../dashboard_staff.php");
        exit();
    }
}
