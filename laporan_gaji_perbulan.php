<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

include 'koneksi.php';

// Fungsi untuk mendapatkan daftar bulan
function getDaftarBulan()
{
    $daftarBulan = array();
    for ($i = 1; $i <= 12; $i++) {
        $daftarBulan[$i] = date("F", mktime(0, 0, 0, $i, 10));
    }
    return $daftarBulan;
}

$daftarBulan = getDaftarBulan();
$tahunSekarang = date("Y");
$bulanDipilih = isset($_GET['bulan']) ? $_GET['bulan'] : date("n");
$tahunDipilih = isset($_GET['tahun']) ? $_GET['tahun'] : $tahunSekarang;

// Query untuk mengambil data laporan gaji
$sql = "SELECT g.no_slipgaji, s.nip, s.nm_staf, g.tgl_gaji, g.gaji_kotor, g.gaji_bersih, g.status,
               COALESCE(dg.total_kehadiran, 0) as total_kehadiran,
               COALESCE(dg.total_potongan, 0) as total_potongan, g.bulan
        FROM gaji g
        INNER JOIN staf s ON g.nip = s.nip
        LEFT JOIN detail_gaji dg ON g.no_slipgaji = dg.no_slipgaji
        WHERE MONTH(g.tgl_gaji) = ? AND YEAR(g.tgl_gaji) = ?
        ORDER BY g.tgl_gaji ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bulanDipilih, $tahunDipilih);
$stmt->execute();
$result = $stmt->get_result();

// Hitung total kehadiran dan total potongan
$totalKehadiran = 0;
$totalPotongan = 0;
$totalGajiKotor = 0;
$totalGajiBersih = 0;
while ($row = $result->fetch_assoc()) {
    $totalKehadiran += $row['total_kehadiran'];
    $totalPotongan += $row['total_potongan'];
    $totalGajiKotor += $row['gaji_kotor'];
    $totalGajiBersih += $row['gaji_bersih'];
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <title>Dashboard Admin</title>

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--<title>Dashboard Sidebar Menu</title>-->
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
</head>

<body class="bg-primary bg-opacity-25">
    <div class="sidebar no-print">
        <?php include('sidebar.php') ?>
    </div>
    <!-- Main Content -->
    <section class="home bg-light bg-opacity-25 printable">
        <div class="ps-5 pe-5 pt-2 ">
            <h2 class="ms-0 text-center">Laporan Gaji Bulanan</h2>
            <div class="card mb-4 no-print">
                <div class="card-header">
                    <h5 class="card-title mb-0" style="color: black">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <label for="bulan" class="mr-2">Bulan:</label>
                            <select name="bulan" id="bulan" class="form-control">
                                <?php foreach ($daftarBulan as $angka => $nama) : ?>
                                    <option value="<?= $angka ?>" <?= $angka == $bulanDipilih ? 'selected' : '' ?>>
                                        <?= $nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <label for="tahun" class="mr-2">Tahun:</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <?php for ($i = $tahunSekarang; $i >= $tahunSekarang - 5; $i--) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahunDipilih ? 'selected' : '' ?>><?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0" style="color: black">
                        Laporan Gaji Bulan <?= $daftarBulan[$bulanDipilih] ?> <?= $tahunDipilih ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Staf</th>
                                    <th>Tanggal Gaji</th>
                                    <th>Gaji Kotor</th>
                                    <th>Total Potongan</th>
                                    <th>Gaji Bersih</th>
                                    <th>Total Kehadiran</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $total = 0;
                                $result->data_seek(0); // Reset pointer to start of result set
                                while ($row = $result->fetch_assoc()) :
                                    $nip = $row['nip'];
                                    $bulan = $row['bulan'];
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
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nip'] ?></td>
                                        <td><?= $row['nm_staf'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['tgl_gaji'])) ?></td>
                                        <td>Rp <?= number_format($row['gaji_kotor'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($row['gaji_kotor'] - $row['gaji_bersih'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($row['gaji_bersih'], 0, ',', '.') ?></td>
                                        <td><?= $totalHadir ?></td>
                                        <td><?= $row['status'] ?></td>
                                    </tr>
                                <?php $total = $total + $row['gaji_kotor'] - $row['gaji_bersih'];
                                endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th>Rp <?= number_format($totalGajiKotor, 0, ',', '.') ?></th>
                                    <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                                    <th>Rp <?= number_format($totalGajiBersih, 0, ',', '.') ?></th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>

                        </table>
                        <div class="mt-3 no-print">
                            <button onclick="window.print()" class="btn btn-success">
                                <i class="fas fa-print mr-2"></i>Cetak Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");


        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        })

        searchBtn.addEventListener("click", () => {
            sidebar.classList.remove("close");
        })

        modeSwitch.addEventListener("click", () => {
            body.classList.toggle("dark");

            if (body.classList.contains("dark")) {
                modeText.innerText = "Light mode";
            } else {
                modeText.innerText = "Dark mode";

            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>
</body>

</html>