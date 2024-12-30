<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

// Fungsi untuk mendapatkan nama staf berdasarkan NIP
function getNamaStaf($conn, $nip)
{
    $sql = "SELECT nm_staf FROM staf WHERE nip = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nip);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['nm_staf'];
    }
    return "Nama tidak ditemukan";
}

// Tangkap input pencarian (jika ada)
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Modifikasi SQL untuk pencarian
$sql = "SELECT * FROM gaji WHERE nip LIKE ? OR tgl_gaji LIKE ? ORDER BY tgl_gaji DESC";

// Menyiapkan query dengan parameter pencarian
$stmt = $conn->prepare($sql);
$search_query_like = "%" . $search_query . "%"; // menambahkan wildcard untuk pencarian
$stmt->bind_param("ss", $search_query_like, $search_query_like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard Admin</title>
    <link rel="icon" href="logo.png" type="image/x-icon">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-primary bg-opacity-25">
    <?php include('sidebar.php') ?>
    <section class="home bg-light bg-opacity-25">
        <div class="ps-5 pe-5 pt-5">
            <div class="row gx-0" style="margin-left: 0; margin-right: 0;">
                <div class="col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h2 class="mb-4">Daftar Slip Gaji Staf</h2>
                            
                            <!-- Form Pencarian -->
                            <form method="GET" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIP atau Tanggal Gaji" value="<?= htmlspecialchars($search_query); ?>">
                                    <button class="btn btn-primary ms-2" type="submit"><i class="bx bx-search"></i></button>
                                </div>
                            </form>

                            <!-- Tabel Daftar Slip Gaji -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No. Slip Gaji</th>
                                            <th>NIP</th>
                                            <th>Nama Staf</th>
                                            <th>Tanggal Gaji</th>
                                            <th>Gaji Kotor</th>
                                            <th>Gaji Bersih</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["no_slipgaji"] . "</td>";
                                                echo "<td>" . $row["nip"] . "</td>";
                                                echo "<td>" . getNamaStaf($conn, $row["nip"]) . "</td>";
                                                echo "<td>" . date('d-m-Y', strtotime($row["tgl_gaji"])) . "</td>";
                                                echo "<td>Rp " . number_format($row["gaji_kotor"], 0, ',', '.') . "</td>";
                                                echo "<td>Rp " . number_format($row["gaji_bersih"], 0, ',', '.') . "</td>";
                                                echo "<td>" . $row["status"] . "</td>";
                                                echo "<td><a href='detail_slip_gaji.php?nip=" . $row["nip"] . "' class='btn btn-info btn-sm'>Lihat Detail</a></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>Tidak ada data gaji</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>

<?php
$conn->close();
?>
