<?php
// Masukkan file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_golongan = $_POST['id_golongan'];

    // Query untuk menghapus data golongan berdasarkan id_golongan
    $sql = "DELETE FROM golongan WHERE id_golongan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_golongan);

    if ($stmt->execute()) {
        echo 'Data berhasil dihapus';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
