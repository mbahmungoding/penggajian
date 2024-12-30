<?php
session_start();
// Koneksi Database
include 'koneksi.php';

// Fungsi untuk mengambil data golongan dari database
function get_golongan_data()
{
    include 'koneksi.php';
    $sql = "SELECT id_golongan, nm_golongan FROM golongan";
    $result = $conn->query($sql);
    $golongan_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $golongan_data[] = $row;
        }
    }
    $conn->close();
    return $golongan_data;
}

// Fungsi untuk mencari data karyawan
function search_karyawan($search)
{
    include 'koneksi.php';
    $sql = "SELECT * FROM staf WHERE nip LIKE '%$search%' OR nm_staf LIKE '%$search%'";
    $result = $conn->query($sql);
    $karyawan_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $karyawan_data[] = $row;
        }
    }
    $conn->close();
    return $karyawan_data;
}


// Ambil data golongan
$daftar_golongan = get_golongan_data();

// Menangani pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$daftar_karyawan = $search ? search_karyawan($search) : [];
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
                                            <h2>Daftar Karyawan</h2>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalInputStaf"><i class="fas fa-plus"></i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                                </svg>
                                                &nbsp;Tambah
                                            </button>
                                        </td>
                                    </tr>
                                </table>

                                 <!-- Form Pencarian -->
                                 <form method="GET" action="">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="search" placeholder="Cari Karyawan (NIP, Nama)" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary ms-2" type="button" > <i class="bx bx-search"></i> </button>
                                        </div>
                                    </div>
                                </form>

                                 <!-- Menampilkan Daftar Karyawan -->
                                 <?php if (count($daftar_karyawan) > 0) : ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>NIP</th>
                                                <th>Nama Staf</th>
                                                <th>Golongan</th>
                                                <th>Alamat</th>
                                                <th>Tanggal Masuk Kerja</th>
                                                <th>No Telp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($daftar_karyawan as $staf) : ?>
                                                <tr>
                                                    <td><?= $staf['nip']; ?></td>
                                                    <td><?= $staf['nm_staf']; ?></td>
                                                    <td><?= $staf['id_golongan']; ?></td>
                                                    <td><?= $staf['alamat']; ?></td>
                                                    <td><?= $staf['tgl_masuk_kerja']; ?></td>
                                                    <td><?= $staf['no_telp']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <br>
                                <?php endif; ?>


                                
                                <?php include 'daftar_staf.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Input Staf -->
        <div class="modal fade" id="modalInputStaf" tabindex="-1" role="dialog" aria-labelledby="modalInputStafLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInputStafLabel">Input Staf</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-input-staf-modal">
                            <div class="form-group">
                                <label for="nip_modal">NIP</label>
                                <input type="number" class="form-control" id="nip_modal" name="nip" required>
                            </div>
                            <div class="form-group">
                                <label for="id_golongan_modal">Nama Golongan:</label>
                                <select class="form-control" id="id_golongan_modal" name="id_golongan" required>
                                    <option value="">Pilih Golongan</option>
                                    <?php foreach ($daftar_golongan as $golongan) : ?>
                                        <option value="<?= $golongan['id_golongan']; ?>">
                                            <?= $golongan['nm_golongan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nm_staf_modal">Nama Staf</label>
                                <input type="text" class="form-control" id="nm_staf_modal" name="nm_staf" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_modal">Alamat</label>
                                <input type="text" class="form-control" id="alamat_modal" name="alamat" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_masuk_kerja_modal">Tanggal Masuk Kerja</label>
                                <input type="date" class="form-control" id="tgl_masuk_kerja_modal" name="tgl_masuk_kerja" required>
                            </div>
                            <div class="form-group">
                                <label for="no_telp_modal">No Telp</label>
                                <input type="number" class="form-control" id="no_telp_modal" name="no_telp" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btn-submit-modal">Submit</button>
                    </div>
                </div>
            </div>
        </div>

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
                // Event listener untuk tombol Submit di modal Input
                $("#btn-submit-modal").click(function(e) {
                    e.preventDefault(); // Mencegah pengiriman form secara default

                    // Mendapatkan nilai dari input modal
                    var nip = $("#nip_modal").val();
                    var id_golongan = $("#id_golongan_modal").val();
                    var nm_staf = $("#nm_staf_modal").val();
                    var alamat = $("#alamat_modal").val();
                    var tgl_masuk_kerja = $("#tgl_masuk_kerja_modal").val();
                    var no_telp = $("#no_telp_modal").val();

                    // Objek data untuk dikirim ke server
                    var formData = {
                        nip: nip,
                        id_golongan: id_golongan,
                        nm_staf: nm_staf,
                        alamat: alamat,
                        tgl_masuk_kerja: tgl_masuk_kerja,
                        no_telp: no_telp
                    };

                    // Kirim data ke server menggunakan AJAX
                    $.ajax({
                        type: "POST",
                        url: "input_staf.php",
                        data: formData,
                        success: function(response) {
                            console.log(response); // Tampilkan respons dari server

                            // Kosongkan input setelah data ditambahkan
                            $("#nip_modal").val("");
                            $("#id_golongan_modal").val("");
                            $("#nm_staf_modal").val("");
                            $("#alamat_modal").val("");
                            $("#tgl_masuk_kerja_modal").val("");
                            $("#no_telp_modal").val("");
                            $("#password").val("");

                            // Tutup modal setelah data ditambahkan
                            $("#modalInputStaf").modal("hide");
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Tampilkan error jika ada
                        }
                    });
                });
            });
        </script>

        
        <?php
        // Proses penyimpanan data ke database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nip = $_POST['nip'];
            $id_golongan = $_POST['id_golongan'];
            $nm_staf = $_POST['nm_staf'];
            $alamat = $_POST['alamat'];
            $tgl_masuk_kerja = $_POST['tgl_masuk_kerja'];
            $no_telp = $_POST['no_telp'];
            $pass = $_POST['password'];
            $md5 = md5($pass);

            // Koneksi ke database
            $conn = new mysqli('localhost', 'root', '', 'penggajian');

            // Periksa koneksi
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Query untuk menyimpan data ke dalam tabel 'staf'
            $sql = "INSERT INTO staf (nip, password, id_golongan, nm_staf, alamat, tgl_masuk_kerja, no_telp) 
                    VALUES ('$nip', '$md5', '$id_golongan', '$nm_staf', '$alamat', '$tgl_masuk_kerja', '$no_telp')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['pesan'] = "Berhasil menambah data Staf";
            } else {
                echo 'Error: ' . $sql . '<br>' . $conn->error;
            }

            $conn->close();
        }
        ?>
</body>

</html>