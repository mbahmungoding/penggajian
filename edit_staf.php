<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form edit modal
    $nip = $_POST['nip'];
    $id_golongan = $_POST['nm_golongan'];
    $nama_staf = $_POST['nm_staf'];
    $alamat = $_POST['alamat'];
    $tgl_masuk_kerja = $_POST['tgl_masuk_kerja'];
    $no_telp = $_POST['no_telp'];
    $pass = md5($_POST['password']);

    // Query update data staf berdasarkan NIP
    $sql = "UPDATE staf SET password = ?, id_golongan = ?, nm_staf = ?, alamat = ?, tgl_masuk_kerja = ?, no_telp = ? WHERE nip = ?";
    $stmt = $conn->prepare($sql);

    // Menggunakan 's' untuk string dan 'i' untuk integer, jika id_golongan adalah integer dan password juga merupakan string
    $stmt->bind_param('sissssi', $pass, $id_golongan, $nama_staf, $alamat, $tgl_masuk_kerja, $no_telp, $nip);

    if ($stmt->execute()) {
        echo "Behasil mengedit staf";
    } else {
        echo "Gagal memperbarui data staf: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
