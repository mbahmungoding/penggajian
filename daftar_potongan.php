<?php
// Masukkan file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';

// Query untuk mengambil data dari tabel potongan dengan nama staf dan jumlah kehadiran
$sql = "SELECT p.id_potongan, s.nm_staf, k.jmlh_kehadiran, p.potongan_bpjs, p.potongan_kehadiran, p.jmlh_potongan 
        FROM potongan p
        JOIN kehadiran k ON p.id_kehadiran = k.id_kehadiran
        JOIN staf s ON k.nip = s.nip";
$result = $conn->query($sql);

// Array untuk menyimpan data potongan
$daftar_potongan = [];

if ($result->num_rows > 0) {
    // Memasukkan data dari hasil query ke dalam array
    while($row = $result->fetch_assoc()) {
        $daftar_potongan[] = $row;
    }
} else {
    echo "Tidak ada data potongan.";
}

// Tutup koneksi setelah selesai menggunakan
$conn->close();
?>

<!-- Tabel untuk menampilkan data potongan dengan nama staf dan jumlah kehadiran -->
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>ID Potongan</th>
            <th>Nama Staf</th>
            <th>Jumlah Kehadiran</th>
            <th>Potongan BPJS</th>
            <th>Potongan Kehadiran</th>
            <th>Jumlah Potongan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="potonganTableBody">
        <!-- Menampilkan data dari PHP ke dalam tabel -->
        <?php
        foreach ($daftar_potongan as $index => $potongan): ?>
            <tr data-id="<?= $potongan['id_potongan']; ?>">
                <td><?= $index + 1; ?></td>
                <td><?= $potongan['id_potongan']; ?></td>
                <td><?= $potongan['nm_staf']; ?></td>
                <td><?= htmlspecialchars($potongan['jmlh_kehadiran']); ?></td>
                <td><?= $potongan['potongan_bpjs']; ?></td>
                <td><?= $potongan['potongan_kehadiran']; ?></td>
                <td><?= $potongan['jmlh_potongan']; ?></td>
                <td>
                    <button class="btn btn-info btn-sm edit-btn" data-id="<?= $potongan['id_potongan']; ?>" data-toggle="modal" data-target="#modalEditPotongan">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $potongan['id_potongan']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal Edit Potongan -->
<div class="modal fade" id="modalEditPotongan" tabindex="-1" role="dialog" aria-labelledby="modalEditPotonganLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPotonganLabel">Edit Potongan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-potongan-modal">
                    <input type="hidden" id="edit_id_potongan" name="id_potongan">
                    <div class="form-group">
                        <label for="edit_nm_staf">Nama Staf:</label>
                        <input type="text" class="form-control" id="edit_nm_staf" name="nm_staf" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_jmlh_kehadiran">Jumlah Kehadiran:</label>
                        <input type="text" class="form-control" id="edit_jmlh_kehadiran" name="jmlh_kehadiran" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_potongan_bpjs">Potongan BPJS:</label>
                        <input type="number" class="form-control" id="edit_potongan_bpjs" name="potongan_bpjs" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_potongan_kehadiran">Potongan Kehadiran:</label>
                        <input type="number" class="form-control" id="edit_potongan_kehadiran" name="potongan_kehadiran" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jmlh_potongan">Jumlah Potongan:</label>
                        <input type="number" class="form-control" id="edit_jmlh_potongan" name="jmlh_potongan" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-update-potongan">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Skrip JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol Edit di tabel
    $(document).on("click", ".edit-btn", function(){
        const row = $(this).closest("tr");
        const id = row.data("id");
        const nmStaf = row.find("td:eq(2)").text();
        const jmlhKehadiran = row.find("td:eq(3)").text();
        const potonganBpjs = row.find("td:eq(4)").text();
        const potonganKehadiran = row.find("td:eq(5)").text();
        const jmlhPotongan = row.find("td:eq(6)").text();

        // Set nilai input modal dengan nilai dari baris tabel yang ingin diedit
        $("#edit_id_potongan").val(id);
        $("#edit_nm_staf").val(nmStaf);
        $("#edit_jmlh_kehadiran").val(jmlhKehadiran);
        $("#edit_potongan_bpjs").val(potonganBpjs);
        $("#edit_potongan_kehadiran").val(potonganKehadiran);
        $("#edit_jmlh_potongan").val(jmlhPotongan);
    });

    // Event listener untuk input potongan BPJS di modal Edit
    $("#edit_potongan_bpjs").on("input", function() {
        hitungJumlahPotongan();
    });

    // Event listener untuk input potongan kehadiran di modal Edit
    $("#edit_potongan_kehadiran").on("input", function() {
        hitungJumlahPotongan();
    });

    // Fungsi untuk menghitung ulang jumlah potongan
    function hitungJumlahPotongan() {
        const potonganBpjs = parseFloat($("#edit_potongan_bpjs").val()) || 0;
        const potonganKehadiran = parseFloat($("#edit_potongan_kehadiran").val()) || 0;
        const jmlhPotongan = potonganBpjs + potonganKehadiran;
        $("#edit_jmlh_potongan").val(jmlhPotongan);
    }

    // Event listener untuk tombol Update di modal Edit
    $("#btn-update-potongan").click(function(){
        const formData = $("#form-edit-potongan-modal").serialize();

        $.ajax({
            type: "POST",
            url: "edit_potongan.php",
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
    $(document).on("click", ".delete-btn", function(){
        const row = $(this).closest("tr");
        const id = row.data("id");

        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                type: "POST",
                url: "hapus_potongan.php",
                data: { id_potongan: id },
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