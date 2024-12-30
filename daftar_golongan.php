<?php
// At the beginning of daftar_golongan.php, add this function:
function get_golongan_data()
{
    include 'koneksi.php';
    $sql = "SELECT id_golongan, nm_golongan, pend_akhir, gapok FROM golongan";
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

// Retrieve data golongan
$daftar_golongan = get_golongan_data();
?>

<!-- Tabel untuk menampilkan data golongan -->
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th class="text-center align-middle">No</th>
            <th class="text-center align-middle">Nama Golongan</th>
            <th class="text-center align-middle">Pendidikan Terakhir</th>
            <th class="text-center align-middle">Gaji Pokok</th>
            <th class="text-center align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody id="golonganTableBody">
        <!-- Menampilkan data dari PHP ke dalam tabel -->
        <?php if (!empty($daftar_golongan)) : ?>
            <?php foreach ($daftar_golongan as $index => $golongan) : ?>
                <tr data-id="<?= $golongan['id_golongan']; ?>">
                    <td class="text-center align-middle"><?= $index + 1; ?></td>
                    <td class="text-center align-middle"><?= $golongan['nm_golongan']; ?></td>
                    <td class="text-center align-middle"><?= $golongan['pend_akhir']; ?></td>
                    <td class="text-center align-middle"><?= "Rp " . number_format($golongan['gapok'], 0, ',', '.'); ?></td>
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
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada data golongan.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Modal Edit Golongan -->
<div class="modal fade" id="modalEditGolongan" tabindex="-1" role="dialog" aria-labelledby="modalEditGolonganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditGolonganLabel">Edit Golongan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-golongan-modal">
                    <input type="hidden" id="edit_id_golongan" name="id_golongan">
                    <div class="form-group">
                        <label for="edit_nm_golongan">Nama Golongan:</label>
                        <input type="text" class="form-control" id="edit_nm_golongan" name="nm_golongan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_pend_akhir">Pendidikan Terakhir:</label>
                        <input type="text" class="form-control" id="edit_pend_akhir" name="pend_akhir" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_gapok">Gaji Pokok:</label>
                        <input type="number" class="form-control" id="edit_gapok" name="gapok" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-update-golongan">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('#golonganTableBody tr');
        let nomor = 1;

        tableRows.forEach(row => {
            const noCell = row.querySelector('td:first-child');
            noCell.textContent = nomor;
            nomor++;
        });

        // Event listener untuk tombol Edit di tabel
        $(document).on("click", ".edit-btn", function() {
            const row = $(this).closest("tr");
            const id = row.data("id");
            const namaGolongan = row.find("td:eq(1)").text();
            const pendAkhir = row.find("td:eq(2)").text();
            const gapok = row.find("td:eq(3)").text();

            // Set nilai input modal dengan nilai dari baris tabel yang ingin diedit
            $("#edit_id_golongan").val(id);
            $("#edit_nm_golongan").val(namaGolongan);
            $("#edit_pend_akhir").val(pendAkhir);
            $("#edit_gapok").val(gapok);
        });

        // Event listener untuk tombol Update di modal Edit
        $("#btn-update-golongan").click(function() {
            const formData = $("#form-edit-golongan-modal").serialize();

            $.ajax({
                type: "POST",
                url: "edit_golongan.php",
                data: formData,
                success: function(response) {
                    alert(response);
                    location.reload(); // Refresh halaman setelah data diperbarui
                },
                error: function(xhr, status, error) {
                    console.error(error); // Tampilkan error jika ada
                }
            });
        });

        // Event listener untuk tombol Delete di tabel
        $(document).on("click", ".delete-btn", function() {
            const row = $(this).closest("tr");
            const id = row.data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    type: "POST",
                    url: "hapus_golongan.php",
                    data: {
                        id_golongan: id
                    },
                    success: function(response) {
                        alert(response);
                        location.reload(); // Refresh halaman setelah data dihapus
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Tampilkan error jika ada
                    }
                });
            }
        });
    });
</script>