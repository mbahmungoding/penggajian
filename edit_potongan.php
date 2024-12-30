<?php
// Masukkan file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';

// Pastikan ada data yang dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim melalui AJAX
    $id_potongan = $_POST['id_potongan'];
    $potongan_bpjs = $_POST['potongan_bpjs'];
    $potongan_kehadiran = $_POST['potongan_kehadiran'];
    $jmlh_potongan = $_POST['jmlh_potongan'];

    // Query untuk melakukan update data potongan berdasarkan id_potongan
    $sql = "UPDATE potongan SET potongan_bpjs = '$potongan_bpjs', potongan_kehadiran = '$potongan_kehadiran', jmlh_potongan = '$jmlh_potongan' WHERE id_potongan = '$id_potongan'";

    if ($conn->query($sql) === TRUE) {
        echo "Data potongan berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi setelah selesai menggunakan
$conn->close();
?>
