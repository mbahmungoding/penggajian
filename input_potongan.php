<?php
// Koneksi Database
session_start();
include 'koneksi.php';

// Fungsi untuk mengambil data kehadiran dari database
function get_kehadiran_data()
{
    global $conn;
    $sql = "SELECT k.id_kehadiran, s.nm_staf, k.jmlh_kehadiran 
            FROM kehadiran k
            JOIN staf s ON k.nip = s.nip";
    $result = $conn->query($sql);
    $kehadiran_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $kehadiran_data[] = $row;
        }
    }
    return $kehadiran_data;
}

// Fungsi untuk mendapatkan ID potongan terbaru
function get_new_id_potongan()
{
    global $conn;
    $sql = "SELECT MAX(id_potongan) AS max_id FROM potongan";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $max_id = $row['max_id'];

    if (!$max_id) {
        // Jika belum ada data sama sekali, mulai dari 1
        $new_id = 1;
    } else {
        // Ambil angka dari ID terakhir dan tambahkan 1
        $new_id = (int) $max_id + 1;
    }

    // Batasi hingga 1000 (jika lebih besar dari 1000, sesuaikan sesuai kebutuhan)
    if ($new_id > 1000) {
        $new_id = 1000;
    }

    return $new_id;
}

// Ambil data kehadiran
$daftar_kehadiran = get_kehadiran_data();
$new_id_potongan = get_new_id_potongan();

// Proses input potongan jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form input
    $id_potongan = $_POST['id_potongan'];
    $potongan_bpjs = $_POST['potongan_bpjs'];
    $potongan_kehadiran = $_POST['potongan_kehadiran'];
    $jmlh_potongan = $_POST['jmlh_potongan'];
    $id_kehadiran = $_POST['id_kehadiran'];

    // Query untuk menyimpan data potongan ke database
    $sql = "UPDATE potongan SET potongan_bpjs = $potongan_bpjs WHERE id_potongan = 13";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['pesan'] = "Berhasil mengupdate potongan BPJS";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                                            <h2>Daftar Potongan</h2>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalInputPotongan">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                                &nbsp;Edit
                                            </button>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Tampilkan tabel daftar potongan di sini -->
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Porongan BPJS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kehadiranTableBody">
                                        <?php
                                        $index = 1;
                                        $sql = "SELECT * FROM potongan";
                                        $query = mysqli_query($conn, $sql);
                                        if ($query->num_rows > 0) {
                                            while ($row = $query->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?= $index++; ?></td>
                                                    <td class="text-end">Rp. <?= number_format($row['potongan_bpjs'], 2, ',', '.'); ?></td>
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
            </div>

            <!-- Modal Input Potongan -->
            <div class="modal fade" id="modalInputPotongan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Potongan</h1>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $sql = "SELECT * FROM potongan";
                            $query = mysqli_query($conn, $sql);
                            if ($query->num_rows > 0) {
                                $data = $query->fetch_assoc();
                            ?>
                                <form id="form-input-potongan-modal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <label for="potongan_bpjs_modal">Potongan BPJS:</label>
                                        <input type="number" class="form-control" id="potongan_bpjs_modal" name="potongan_bpjs" value="<?php echo $data['potongan_bpjs'] ?>" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary" id="btn-submit-modal">Submit</button>
                                    </div>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JavaScript -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                    var toastList = toastElList.map(function(toastEl) {
                        return new bootstrap.Toast(toastEl, {
                            autohide: false
                        });
                    });
                    toastList.forEach(toast => toast.show());
                });
            </script>
            <script>
                $(document).ready(function() {
                    // Mengisi jumlah kehadiran otomatis saat memilih staf
                    $("#id_kehadiran_modal").change(function() {
                        var selectedOption = $(this).find("option:selected");
                        var jmlhKehadiran = selectedOption.data("kehadiran");
                        $("#jmlh_kehadiran_modal").val(jmlhKehadiran);
                    });

                    // Menghitung jumlah potongan otomatis
                    $("#potongan_bpjs_modal, #potongan_kehadiran_modal").on("input", function() {
                        var potonganBpjs = parseFloat($("#potongan_bpjs_modal").val()) || 0;
                        var potonganKehadiran = parseFloat($("#potongan_kehadiran_modal").val()) || 0;
                        var jmlhPotongan = potonganBpjs + potonganKehadiran;
                        $("#jmlh_potongan_modal").val(jmlhPotongan);
                    });

                    // Event listener untuk tombol Submit di modal Input
                    $("#form-input-potongan-modal").submit(function(e) {
                        e.preventDefault(); // Mencegah pengiriman form secara default

                        // Mendapatkan nilai dari input modal
                        var formData = $(this).serialize();

                        // Kirim data ke server menggunakan AJAX
                        $.ajax({
                            type: "POST",
                            url: "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>",
                            data: formData,
                            success: function(response) {
                                console.log(response); // Tampilkan respons dari server

                                // Kosongkan form dan tutup modal
                                $("#form-input-potongan-modal")[0].reset();
                                $("#modalInputPotongan").modal("hide");

                                // Reload halaman untuk memperbarui tabel
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.error(error); // Tampilkan pesan error
                            }
                        });
                    });
                });
            </script>
</body>

</html>