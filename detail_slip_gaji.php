<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

if (isset($_GET['nip'])) {
    $nip = intval($_GET['nip']);

    // Query pertama tanpa parameter
    $sql = "SELECT * FROM gaji INNER JOIN staf ON gaji.nip = staf.nip WHERE gaji.nip = $nip ORDER BY gaji.no_slipgaji DESC";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        // Ambil nama staf
        $sql_staf = "SELECT nm_staf FROM staf WHERE nip = ?";
        $stmt_staf = $conn->prepare($sql_staf);
        $stmt_staf->bind_param("i", $nip);
        $stmt_staf->execute();
        $result_staf = $stmt_staf->get_result();

        if ($result_staf->num_rows > 0) {
            $staf = $result_staf->fetch_assoc();
            $namaStaf = $staf['nm_staf'];
        } else {
            echo "Nama staf tidak ditemukan.";
            exit;
        }
    } else {
        echo "Data slip gaji tidak ditemukan.";
        exit;
    }
}

?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard Admin</title>

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        @media print {
            body * {
                margin: 0;
                visibility: hidden;

                /* Hide everything by default */
            }

            .no-print {
                display: none;
            }

            .printable,
            .printable * {
                visibility: visible;
                /* Make printable content visible */
            }

            .printable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;

            }
        }
    </style>
    <!--<title>Dashboard Sidebar Menu</title>-->
</head>

<body class="bg-primary bg-opacity-25">
    <div class="sidebar no-print">
        <?php include('sidebar.php') ?>
    </div>
    <section class="home bg-light bg-opacity-25 printable">
        <div class="ps-5 pe-5 pt-5">
            <div class="row gx-0" style="margin-left: 0; margin-right: 0;">
                <div class="col-md-12 mb-4">
                    <?php

                    while ($row = $result->fetch_assoc()) {
                        $nip = $row['nip'];
                        $potongan = $row['gaji_kotor'] - $row['gaji_bersih'];
                        $bulan = $row['bulan'];
                        $pot = "SELECT * FROM potongan";
                        $bpjs = 0;
                        if (mysqli_query($conn, $pot)->num_rows > 0) {
                            $data = mysqli_query($conn, $pot)->fetch_assoc();
                            $bpjs = $data['potongan_bpjs'];
                        }
                        $cari = "SELECT p.nip, MONTH(p.waktu) as bulan, COUNT(*) as total_masuk, s.nm_staf as nama 
                                FROM presensi p 
                                INNER JOIN staf s ON p.nip = s.nip 
                                WHERE YEAR(p.waktu) = YEAR(CURRENT_DATE) AND MONTH(p.waktu) = $bulan AND p.nip = $nip
                                GROUP BY p.nip, MONTH(p.waktu)
                                ";
                        if (mysqli_query($conn, $cari)->num_rows > 0) {
                            $data = mysqli_query($conn, $cari)->fetch_assoc();
                            $totalHadir = $data['total_masuk'];
                        }
                        $hadir = $row["gaji_kotor"] - ($row["gaji_bersih"] + $bpjs);

                    ?>
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <div class="form-table">

                                    <h2 class="mb-4 text-center">Slip Gaji - <?= $namaStaf; ?></h2>

                                    <div class="slip-gaji">
                                        <div class="slip-header">
                                            <h4>Slip Gaji #<?= $row["no_slipgaji"] ?></h4>
                                            <p>Tanggal: <?= date('d-m-Y', strtotime($row["tgl_gaji"])) ?></p>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>NIP:</strong> <?= $nip ?></p>
                                                <p><strong>Nama:</strong> <?= $namaStaf ?></p>
                                                <p><strong>Status:</strong> <?= $row["status"] ?></p>
                                                <p><strong>Total Kehadiran:</strong> <?= $totalHadir ?? 0 ?> hari</p>
                                            </div>
                                            <div class="col-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>Gaji Kotor</strong></td>
                                                        <td class="text-end">Rp <?= number_format($row["gaji_kotor"], 0, ',', '.') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Potongan BPJS</strong></td>
                                                        <td class="text-end">- Rp <?= number_format($bpjs, 0, ',', '.') ?></td>
                                                    </tr>
                                                    <tr class="border-bottom">
                                                        <td><strong>Potongan Absen</strong></td>
                                                        <td class="text-end">- Rp <?= number_format($hadir, 0, ',', '.') ?></td>
                                                    </tr>
                                                    <tr class="">
                                                        <td><strong>Gaji Bersih</strong></td>
                                                        <td class="text-end">Rp <?= number_format($row['gaji_bersih'], 0, ',', '.') ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="slip-footer">
                                            <p><em>Slip gaji ini dihasilkan secara otomatis dan sah tanpa tanda tangan.</em></p>
                                        </div>
                                        <button class="btn btn-primary mt-3 no-print" onclick="window.print()">Cetak Slip Gaji</button>
                                    </div>

                                    <div class="text-center no-print">
                                        <a href="slip_gaji.php" class="btn btn-secondary">Kembali ke Daftar Slip Gaji</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>