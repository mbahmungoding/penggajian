<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_staf = $_POST['nip'];

    $sql = "DELETE FROM staf WHERE nip = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_staf);

    if ($stmt->execute()) {
        echo 'Data berhasil dihapus';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
