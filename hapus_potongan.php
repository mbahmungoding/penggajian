<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_potongan = $_POST['id_potongan'];

    $sql = "DELETE FROM potongan WHERE id_potongan='$id_potongan'";

    if ($conn->query($sql) === TRUE) {
        echo "Data potongan berhasil dihapus";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>