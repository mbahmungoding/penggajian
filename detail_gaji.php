<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

include 'koneksi.php';

if (!isset($_GET['no_slipgaji'])) {
    echo "No slip gaji tidak ditemukan.";
    exit;
}

$no_slipgaji = $_GET['no_slipgaji'];

$sql = "SELECT g.no_slipgaji, s.nip, s.nm_staf, g.tgl_gaji, g.gaji_kotor, g.gaji_bersih, g.status,
               (SELECT SUM(jmlh_potongan) FROM potongan WHERE id_kehadiran IN 
                (SELECT id_kehadiran FROM kehadiran WHERE nip = s.nip)) AS total_potongan,
               (SELECT SUM(jmlh_kehadiran) FROM kehadiran WHERE nip = s.nip) AS total_kehadiran
        FROM gaji g
        INNER JOIN staf s ON g.nip = s.nip
        WHERE g.no_slipgaji = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $no_slipgaji);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Data gaji tidak ditemukan.";
    exit;
}

$gaji = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Gaji</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }
        .sidebar {
            height: 100vh;
            background-color: #2c3e50;
            padding: 20px;
            color: #ecf0f1;
        }
        .sidebar h4 {
            margin-bottom: 20px;
            text-align: center;
            color: #3498db;
        }
        .sidebar ul.nav.flex-column {
            padding-left: 0;
            list-style-type: none;
        }
        .sidebar ul.nav.flex-column li.nav-item a.nav-link {
            color: #bdc3c7;
            transition: all 0.3s;
        }
        .sidebar ul.nav.flex-column li.nav-item a.nav-link:hover {
            color: #3498db;
            background-color: #34495e;
            border-radius: 5px;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            background-color: #ffffff;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #3498db;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            color: #2c3e50;
        }
        .table td {
            color: #34495e;
        }
        .btn-back {
            margin-top: 20px;
            background-color: #2ecc71;
            border: none;
            transition: all 0.3s;
        }
        .btn-back:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }
        .status-badge {
            font-size: 0.9em;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .icon-column {
            width: 40px;
            text-align: center;
            color: #3498db;
        }
        @media (max-width: 768px) {
            .sidebar {
                height: auto;
            }
            .card-body .row {
                flex-direction: column;
            }
            .col-md-6 {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0">
                <div class="sidebar">
                    <?php include 'sidebar.php'; ?>
                </div>
            </div>
            <!-- Konten Utama -->
            <div class="col-md-10">
                <div class="main-content">
                    <h2 class="text-center mb-4 text-primary">Detail Gaji</h2>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-invoice-dollar mr-2"></i>
                                Slip Gaji No: <?= $gaji['no_slipgaji']; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-hover">
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-id-card"></i></th>
                                            <th>NIP</th>
                                            <td><?= $gaji['nip']; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-user"></i></th>
                                            <th>Nama Staf</th>
                                            <td><?= $gaji['nm_staf']; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-calendar-alt"></i></th>
                                            <th>Tanggal Gaji</th>
                                            <td><?= $gaji['tgl_gaji']; ?></td>
                                        </tr>
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-clock"></i></th>
                                            <th>Total Kehadiran</th>
                                            <td><?= $gaji['total_kehadiran'] ?? 0; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-hover">
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-money-bill-wave"></i></th>
                                            <th>Gaji Kotor</th>
                                            <td>Rp <?= number_format($gaji['gaji_kotor'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-hand-holding-usd"></i></th>
                                            <th>Gaji Bersih</th>
                                            <td>Rp <?= number_format($gaji['gaji_bersih'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-cut"></i></th>
                                            <th>Total Potongan</th>
                                            <td>Rp <?= number_format($gaji['total_potongan'] ?? 0, 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="icon-column"><i class="fas fa-info-circle"></i></th>
                                            <th>Status</th>
                                            <td>
                                                <span class="status-badge badge <?= $gaji['status'] == 'Dibayar' ? 'badge-success' : 'badge-warning'; ?>">
                                                    <?= $gaji['status']; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="kembali()" class="btn btn-primary btn-back mt-3">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Gaji
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function kembali() {
            window.history.back();
        }
    </script>
</body>
</html>