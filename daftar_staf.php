<?php
// Masukkan file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';

// Fungsi untuk mengambil nama golongan berdasarkan id_golongan
function get_nama_golongan($id_golongan)
{
    include 'koneksi.php';
    $sql = "SELECT nm_golongan FROM golongan WHERE id_golongan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_golongan);
    $stmt->execute();
    $stmt->bind_result($nm_golongan);
    $stmt->fetch();
    $stmt->close();
    return $nm_golongan;
}

// Query untuk mengambil data dari tabel staf
$sql = "SELECT nip, id_golongan, nm_staf, alamat, tgl_masuk_kerja, no_telp FROM staf";
$result = $conn->query($sql);

// Array untuk menyimpan data staf
$daftar_staf = [];

if ($result->num_rows > 0) {
    // Memasukkan data dari hasil query ke dalam array
    while ($row = $result->fetch_assoc()) {
        $row['nm_golongan'] = get_nama_golongan($row['id_golongan']);
        $daftar_staf[] = $row;
    }
} else {
    echo "Tidak ada data staf.";
}

// Tutup koneksi setelah selesai menggunakan
$conn->close();
?>

<!-- Tabel untuk menampilkan data staf -->
<div class="table-responsive mt-3">
    <table class="table table-striped table-bordered table-hover table-sm">
        <thead class="bg-primary text-white">
            <tr>
                <th class="text-center align-middle">No</th>
                <th class="text-center align-middle">NIP</th>
                <th class="text-center align-middle">Nama Golongan</th>
                <th class="text-center align-middle">Nama Staf</th>
                <th class="text-center align-middle">Alamat</th>
                <th class="text-center align-middle">Tanggal Masuk Kerja</th>
                <th class="text-center align-middle">No Telp</th>
                <th class="text-center align-middle">Aksi</th>
            </tr>
        </thead>
        <tbody id="stafTableBody">
            <!-- Menampilkan data dari PHP ke dalam tabel -->
            <?php foreach ($daftar_staf as $index => $staf): ?>
                <tr data-id="<?= $staf['nip']; ?>">
                    <td class="text-center align-middle"><?= $index + 1; ?></td>
                    <td class="text-center align-middle"><?= $staf['nip']; ?></td>
                    <td class="text-center align-middle"><?= $staf['nm_golongan']; ?></td>
                    <td class="align-middle"><?= $staf['nm_staf']; ?></td>
                    <td class="align-middle"><?= $staf['alamat']; ?></td>
                    <td class="text-center align-middle"><?= $staf['tgl_masuk_kerja']; ?></td>
                    <td class="align-middle"><?= $staf['no_telp']; ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-info btn-sm edit-btn" data-id="<?= $staf['nip']; ?>" data-toggle="modal"
                                data-target="#modalEditStaf">
                                <i class="bx bx-edit-alt"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $staf['nip']; ?>">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Edit Staf -->
<div class="modal fade" id="modalEditStaf" tabindex="-1" role="dialog" aria-labelledby="modalEditStafLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditStafLabel">Edit Staf</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-staf-modal">
                    <input type="hidden" id="edit_nip" name="nip">
                    <div class="form-group">
                        <label for="edit_nm_golongan">Nama Golongan:</label>

                        <select class="form-select" id="edit_nm_golongan" name="nm_golongan" required>
                            <option>Pilih Golongan</option>
                            <?php
                            include 'koneksi.php';
                            $sql_golongan = "SELECT id_golongan, nm_golongan FROM golongan";
                            $result_golongan = $conn->query($sql_golongan);
                            while ($row_golongan = $result_golongan->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_golongan['id_golongan'] ?>">
                                    <?php echo $row_golongan['nm_golongan'] ?></option>
                                <?php
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_nm_staf">Nama Staf:</label>
                        <input type="text" class="form-control" id="edit_nm_staf" name="nm_staf" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat:</label>
                        <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_masuk_kerja">Tanggal Masuk Kerja:</label>
                        <input type="date" class="form-control" id="edit_tgl_masuk_kerja" name="tgl_masuk_kerja"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="edit_no_telp">No Telp:</label>
                        <input type="number" class="form-control" id="edit_no_telp" name="no_telp" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-update-staf">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableRows = document.querySelectorAll('#stafTableBody tr');
        let nomor = 1;

        tableRows.forEach(row => {
            const noCell = row.querySelector('td:first-child');
            noCell.textContent = nomor;
            nomor++;
        });

        // Event listener untuk tombol Edit di tabel
        $(document).on("click", ".edit-btn", function () {
            const row = $(this).closest("tr");
            const id = row.data("id");
            const pass = row.find("td:eq(1)").text();
            const idGolongan = row.find("td:eq(2)").text();
            const nama = row.find("td:eq(3)").text();
            const alamat = row.find("td:eq(4)").text();
            const tglMasuk = row.find("td:eq(5)").text();
            const noTelp = row.find("td:eq(6)").text();

            // Set nilai input modal dengan nilai dari baris tabel yang ingin diedit
            $("#edit_nip").val(id);
            $("#edit_nm_golongan").val(idGolongan);
            $("#edit_nm_staf").val(nama);
            $("#edit_alamat").val(alamat);
            $("#edit_tgl_masuk_kerja").val(tglMasuk);
            $("#edit_no_telp").val(noTelp);
            $("#password").val(pass);
        });

        // Event listener untuk tombol Update di modal Edit
        $("#btn-update-staf").click(function () {
            const formData = $("#form-edit-staf-modal").serialize();

            $.ajax({
                type: "POST",
                url: "edit_staf.php",
                data: formData,
                success: function (response) {
                    alert(response);
                    location.reload(); // Refresh halaman setelah data diperbarui
                },
                error: function (xhr, status, error) {
                    console.error(error); // Tampilkan error jika ada
                }
            });
        });

        // Event listener untuk tombol Delete di tabel
        $(document).on("click", ".delete-btn", function () {
            const row = $(this).closest("tr");
            const id = row.data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    type: "POST",
                    url: "hapus_staf.php",
                    data: {
                        nip: id
                    },
                    success: function (response) {
                        alert(response);
                        location.reload(); // Refresh halaman setelah data dihapus
                    },
                    error: function (xhr, status, error) {
                        console.error(error); // Tampilkan error jika ada
                    }
                });
            }
        });
    });
</script>