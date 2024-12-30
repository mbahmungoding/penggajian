<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_slipgaji = $_POST['no_slipgaji'];

    // Persiapkan query untuk menghapus data gaji
    $sql = "DELETE FROM gaji WHERE no_slipgaji = ?";

    // Persiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $no_slipgaji);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Data gaji berhasil dihapus";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    echo "Metode request tidak valid";
}
?>