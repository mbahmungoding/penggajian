<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kehadiran = $_POST['id_kehadiran'];

    // Periksa apakah id_kehadiran ada dan valid
    if (isset($id_kehadiran) && is_numeric($id_kehadiran)) {
        $sql = "DELETE FROM kehadiran WHERE id_kehadiran = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id_kehadiran);

            if ($stmt->execute()) {
                echo "Data kehadiran berhasil dihapus";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "ID kehadiran tidak valid";
    }

    $conn->close();
}
?>
