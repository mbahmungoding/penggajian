<?php
// Koneksi Database
include 'koneksi.php';

// Function to get staff data from the database
function get_staf_data()
{
    global $conn;
    $sql = "SELECT nip, nm_staf FROM staf";
    $result = $conn->query($sql);
    $staf_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $staf_data[] = $row;
        }
    }
    return $staf_data;
}

// Function to get new slip number
function get_new_no_slipgaji()
{
    global $conn;
    $sql = "SELECT MAX(no_slipgaji) AS max_no FROM gaji";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $max_no = $row['max_no'];

    if (!$max_no) {
        return 1;
    } else {
        return (int) $max_no + 1;
    }
}

// Get staff data and new slip number
$daftar_staf = get_staf_data();
$new_no_slipgaji = get_new_no_slipgaji();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_slipgaji = $_POST['no_slipgaji'];
    $nip = $_POST['nip'];
    $tgl_gaji = $_POST['tgl_gaji'];
    $gaji_kotor = $_POST['gaji_kotor'];
    $gaji_bersih = $_POST['gaji_bersih'];
    $status = $_POST['status'];

    $sql = "INSERT INTO gaji (no_slipgaji, nip, tgl_gaji, gaji_kotor, gaji_bersih, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisiis", $no_slipgaji, $nip, $tgl_gaji, $gaji_kotor, $gaji_bersih, $status);

    if ($stmt->execute()) {
        echo "Data gaji berhasil disimpan";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

function hitungTotalHari($bulan, $tahun)
{
    // Menghitung jumlah hari dalam bulan dan tahun yang diberikan
    $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    $total_hari = 0;

    // Iterasi setiap hari dalam bulan
    for ($i = 1; $i <= $jumlah_hari; $i++) {
        $tanggal = strtotime("$tahun-$bulan-$i");

        // Memeriksa apakah hari tersebut adalah Minggu (nilai 7 untuk Minggu dalam date('N'))
        if (date('N', $tanggal) != 7) {
            $total_hari++;
        }
    }

    return $total_hari;
}


// Tangkap input pencarian (jika ada)
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Modifikasi SQL untuk pencarian
$sql2 = "SELECT * FROM gaji 
          INNER JOIN staf ON gaji.nip = staf.nip 
          INNER JOIN golongan ON staf.id_golongan = golongan.id_golongan";

// Tambahkan filter pencarian jika query tidak kosong
if ($search_query !== '') {
    $sql2 .= " WHERE staf.nm_staf LIKE '%$search_query%' 
               OR gaji.nip LIKE '%$search_query%' 
               OR gaji.tgl_gaji LIKE '%$search_query%'";
}

$query = mysqli_query($conn, $sql2);

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
                                <table class="col-md-12">
                                    <tr>
                                        <td>
                                            <h2>Daftar Gaji</h2>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                                data-target="#modalInputGaji"><i class="fas fa-plus"></i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                                </svg>
                                                &nbsp;Tambah
                                            </button>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Pencarian Data -->
                                <form method="GET" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari berdasarkan NIP, Nama Staf, atau Tanggal Gaji"
                                            value="<?= htmlspecialchars($search_query); ?>">
                                        <button class="btn btn-primary ms-2" type="submit"> <i class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Display gaji table -->
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Tanggal Gaji</th>
                                            <th>Gaji Kotor</th>
                                            <th>Gaji Bersih</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kehadiranTableBody">
                                        <?php
                                        $index = 1;
                                        if ($query->num_rows > 0) {
                                            while ($row = $query->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?= $index++; ?></td>
                                                    <td class=""><?= $row['nip']; ?></td>
                                                    <td class=""><?= $row['nm_staf']; ?></td>
                                                    <td class=""><?php echo $row['tgl_gaji'] ?></td>
                                                    <td><?= $row['gapok']; ?></td>
                                                    <td><?php echo $row['gaji_bersih'] ?></td>
                                                    <td><?php echo $row['status'] ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Input Gaji -->
                <div class="modal fade" id="modalInputGaji" tabindex="-1" role="dialog"
                    aria-labelledby="modalInputGajiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalInputGajiLabel">Input Gaji</h5>
                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="action/cari_gaji_staf.php">
                                    <div class="form-group">
                                        <label for="nip_modal">Nama Staf:</label>
                                        <select class="form-control" name="nip" id="nip" required>
                                            <option value="">-Pilih Staf-</option>
                                            <?php foreach ($daftar_staf as $staf): ?>
                                                <option value="<?= $staf['nip']; ?>"><?= $staf['nm_staf']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="bulan">Bulan:</label>
                                        <select class="form-control" id="bulan" name="bulan" required>
                                            <option value="">-Pilih Bulan-</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Gaji:</label>
                                        <input type="date" class="form-control" id="tgl_gaji" name="tgl_gaji">
                                    </div>
                                    <div class="form-group">
                                        <label for="gaji_kotor_modal">Gaji Kotor:</label>
                                        <input type="text" class="form-control" name="gaji_kotor_modal"
                                            id="gaji_kotor_modal">
                                    </div>
                                    <div class="form-group">
                                        <label for="gaji_bersih_modal">Gaji Bersih:</label>
                                        <input type="text" class="form-control" name="gaji_bersih_modal"
                                            id="gaji_bersih_modal">
                                    </div>

                                    <div class="form-group">
                                        <label for="status_modal">Catatan:</label>
                                        <input type="text" class="form-control" id="status_modal" name="status"
                                            required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                            </form>
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


                <script>
                    $(document).ready(function () {
                        $("#bulan").change(function () { // Gunakan event change untuk menanggapi perubahan dropdown
                            var bulan = $(this).val(); // Ambil nilai bulan dari dropdown

                            // Jika bulan dipilih, kirim permintaan AJAX
                            if (bulan !== "") {
                                var nip = $("#nip").val(); // Ambil nilai NIP Staf dari input lain jika diperlukan

                                $.ajax({
                                    url: "action/cari_gaji_staf.php",
                                    method: "GET",
                                    data: {
                                        bulan: bulan,
                                        nip: nip
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        $("#gaji_kotor_modal").val(data.gajiKotor); // Set nilai gaji kotor ke input
                                        $("#gaji_bersih_modal").val(data.gajiBersih); // Set nilai gaji bersih ke input
                                    },
                                    error: function () {
                                        $("#gaji_kotor_modal").val(""); // Kosongkan nilai jika terjadi kesalahan
                                        $("#gaji_bersih_modal").val(""); // Kosongkan nilai jika terjadi kesalahan
                                        console.error("Terjadi kesalahan saat melakukan AJAX request");
                                    }
                                });
                            } else {
                                // Jika tidak ada bulan yang dipilih, kosongkan nilai gaji kotor dan gaji bersih
                                $("#gaji_kotor_modal").val("");
                                $("#gaji_bersih_modal").val("");
                            }
                        });
                    });
                </script>


</body>

</html>