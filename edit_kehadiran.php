<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kehadiran = $_POST['id_kehadiran'];
    $nip = $_POST['nip'];
    $jmlh_kehadiran = $_POST['jmlh_kehadiran'];

    if (isset($id_kehadiran) && is_numeric($id_kehadiran) && isset($nip) && is_numeric($nip) && isset($jmlh_kehadiran)) {
        $sql = "UPDATE kehadiran SET nip = ?, jmlh_kehadiran = ? WHERE id_kehadiran = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isi", $nip, $jmlh_kehadiran, $id_kehadiran);

            if ($stmt->execute()) {
                echo "Data kehadiran berhasil diperbarui";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Data yang diberikan tidak valid";
    }

    $conn->close();
}
?>