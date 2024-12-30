<?php
// Masukkan file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_golongan = $_POST['id_golongan'];
    $nm_golongan = $_POST['nm_golongan'];
    $pend_akhir = $_POST['pend_akhir'];
    $gapok = $_POST['gapok'];

    // Query untuk mengupdate data golongan berdasarkan id_golongan
    $sql = "UPDATE golongan SET nm_golongan = ?, pend_akhir = ?, gapok = ? WHERE id_golongan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssii', $nm_golongan, $pend_akhir, $gapok, $id_golongan);

    if ($stmt->execute()) {
        echo 'Data berhasil diperbarui';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
