<?php
// Koneksi ke database
include("koneksi.php");

// Proses penyimpanan data ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nm_golongan = $_POST['nm_golongan'];
    $pend_akhir = $_POST['pend_akhir'];
    $gapok = $_POST['gapok'];

    // Query untuk menyimpan data ke dalam tabel 'golongan'
    $sql = "INSERT INTO golongan (nm_golongan, pend_akhir, gapok) 
            VALUES ('$nm_golongan', '$pend_akhir', '$gapok')";

    if ($conn->query($sql) === TRUE) {
        echo 'Data berhasil disimpan';
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }

    $conn->close();
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
                            <table class="col-md-12">
                                <tr>
                                    <td>
                                        <h2>Daftar Golongan</h2>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalInputGolongan"><i class="fas fa-plus"></i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                            </svg>
                                            &nbsp;Tambah
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <!-- Display the list of golongan here -->
                            <?php include 'daftar_golongan.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Input Golongan -->
        <div class="modal fade" id="modalInputGolongan" tabindex="-1" role="dialog" aria-labelledby="modalInputGolonganLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInputGolonganLabel">Input Golongan</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formInputGolongan">
                            <div class="form-group">
                                <label for="nm_golongan_modal">Nama Golongan</label>
                                <input type="text" class="form-control" id="nm_golongan_modal" name="nm_golongan" required>
                            </div>
                            <div class="form-group">
                                <label for="pend_akhir_modal">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="pend_akhir_modal" name="pend_akhir" required>
                            </div>
                            <div class="form-group">
                                <label for="gapok_modal">Gaji Pokok</label>
                                <input type="number" class="form-control" id="gapok_modal" name="gapok" required>
                            </div>
                            <div class="form-group pt-3">
                                <button type="submit" class="btn btn-primary" id="btn-submit-modal">Submit</button>
                            </div>
                        </form>
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
        <script>
            $(document).ready(function() {
                // Event listener untuk tombol Submit di modal Input
                $("#formInputGolongan").submit(function(e) {
                    e.preventDefault(); // Mencegah pengiriman form secara default

                    // Mendapatkan nilai dari input modal
                    var nm_golongan = $("#nm_golongan_modal").val();
                    var pend_akhir = $("#pend_akhir_modal").val();
                    var gapok = $("#gapok_modal").val();

                    // Objek data untuk dikirim ke server
                    var formData = {
                        nm_golongan: nm_golongan,
                        pend_akhir: pend_akhir,
                        gapok: gapok
                    };

                    // Kirim data ke server menggunakan AJAX
                    $.ajax({
                        type: "POST",
                        url: "input_golongan.php",
                        data: formData,
                        success: function(response) {
                            console.log(response); // Tampilkan respons dari server

                            // Kosongkan input setelah data ditambahkan
                            $("#nm_golongan_modal").val("");
                            $("#pend_akhir_modal").val("");
                            $("#gapok_modal").val("");

                            // Tutup modal setelah data ditambahkan
                            $("#modalInputGolongan").modal("hide");

                            // Optionally, refresh the list of golongan
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Tampilkan error jika ada
                        }
                    });
                });
            });
        </script>
</body>

</html>