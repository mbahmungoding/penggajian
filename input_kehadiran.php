<?php
// Koneksi Database
include 'koneksi.php';
function get_staf_data()
{
    include 'koneksi.php';
    $sql = "SELECT nip, nm_staf FROM staf";
    $result = $conn->query($sql);
    $staf_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $staf_data[] = $row;
        }
    }
    $conn->close();
    return $staf_data;
}

$daftar_staf = get_staf_data();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard Admin</title>

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--<title>Dashboard Sidebar Menu</title>-->
</head>

<body class="bg-primary bg-opacity-25">
    <?php include('sidebar.php') ?>
    <section class="home bg-light bg-opacity-25">
        <div class="ps-5 pe-5 pt-5">
            <div class="row gx-0" style="margin-left: 0; margin-right: 0;">
                <div class="col-md-12 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="form-table">
                                <h2><i class="fas fa-list"></i> Daftar Kehadiran <span class="align-middle fs-4 badge rounded-pill text-bg-info"><?php echo date('F'); // Menampilkan nama bulan sekarang ?></span>
                                </h2>

                                <div class="input-group mb-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan NIP atau Nama Staf">
                                    <button class="btn btn-primary" type="button">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                                
                                <div class="table-responsive mt-4">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">NIP</th>
                                            <th class="text-center align-middle">Nama Staf</th>
                                            <th class="text-center align-middle">Jumlah Kehadiran</th>
                                            <th class="text-center align-middle">Bulan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kehadiranTableBody">
                                        <?php
                                        $index = 1;
                                        $sql = "SELECT p.nip, MONTH(p.waktu) as bulan, COUNT(*) as total_masuk, s.nm_staf as nama 
                                                FROM presensi p INNER JOIN staf s ON p.nip = s.nip WHERE MONTH(p.waktu) = MONTH(CURRENT_DATE) 
                                                AND YEAR(p.waktu) = YEAR(CURRENT_DATE) GROUP BY p.nip, bulan ORDER BY bulan DESC";
                                        $query = mysqli_query($conn, $sql);
                                        if ($query->num_rows > 0) {
                                            while ($row = $query->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?= $index++; ?></td>
                                                    <td class="text-center align-middle"><?= $row['nip']; ?></td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td class="text-center align-middle"><?= $row['total_masuk']; ?></td>
                                                    <td class="text-center align-middle">
                                                        <?php
                                                        if ($row['bulan'] == 1) {
                                                            echo "Januari";
                                                        } else if ($row['bulan'] == 2) {
                                                            echo "Febuari";
                                                        } else if ($row['bulan'] == 3) {
                                                            echo "Maret";
                                                        } else if ($row['bulan'] == 4) {
                                                            echo "April";
                                                        } else if ($row['bulan'] == 5) {
                                                            echo "Mai";
                                                        } else if ($row['bulan'] == 6) {
                                                            echo "Juni";
                                                        } else if ($row['bulan'] == 7) {
                                                            echo "Juli";
                                                        } else if ($row['bulan'] == 8) {
                                                            echo "Agustus";
                                                        } else if ($row['bulan'] == 9) {
                                                            echo "September";
                                                        } else if ($row['bulan'] == 10) {
                                                            echo "Oktober";
                                                        } else if ($row['bulan'] == 11) {
                                                            echo "November";
                                                        } else if ($row['bulan'] == 12) {
                                                            echo "Desember";
                                                        } else {
                                                            echo "Salah bulan";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
                integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
                crossorigin="anonymous"></script>
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
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- jQuery -->
            <script>
                $(document).ready(function () {
                    $("#btn-submit-modal").click(function (e) {
                        e.preventDefault();

                        var nip = $("#nip_modal").val();
                        var jmlh_kehadiran = $("#jmlh_kehadiran_modal").val();

                        var formData = {
                            nip: nip,
                            jmlh_kehadiran: jmlh_kehadiran
                        };

                        $.ajax({
                            type: "POST",
                            url: "input_kehadiran.php",
                            data: formData,
                            success: function (response) {
                                console.log(response);
                                $("#nip_modal").val("");
                                $("#jmlh_kehadiran_modal").val("");
                                $("#modalInputKehadiran").modal("hide");
                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                });
            </script>

            <!-- JavaScript for Filter -->
            <script>
                document.getElementById('searchInput').addEventListener('keyup', function () {
                    const searchValue = this.value.toLowerCase();
                    const tableRows = document.querySelectorAll('#kehadiranTableBody tr');
                    
                    tableRows.forEach(row => {
                        const nip = row.children[1].textContent.toLowerCase();
                        const nama = row.children[2].textContent.toLowerCase();
                        if (nip.includes(searchValue) || nama.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            </script>
            
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nip = $_POST['nip'];
                $jmlh_kehadiran = $_POST['jmlh_kehadiran'];

                $conn = new mysqli('localhost', 'root', '', 'penggajian');

                if ($conn->connect_error) {
                    die('Connection failed: ' . $conn->connect_error);
                }

                $sql = "INSERT INTO kehadiran (nip, jmlh_kehadiran) 
            VALUES (?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $nip, $jmlh_kehadiran);

                if ($stmt->execute()) {
                    echo 'Data berhasil disimpan';
                } else {
                    echo 'Error: ' . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            }

            ?>

            
</body>