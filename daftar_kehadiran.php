<?php
include 'koneksi.php';

function get_nama_staf($nip) {
    include 'koneksi.php';
    $sql = "SELECT nm_staf FROM staf WHERE nip = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $nip);
    $stmt->execute();
    $stmt->bind_result($nm_staf);
    $stmt->fetch();
    $stmt->close();
    return $nm_staf;
}

$sql = "SELECT id_kehadiran, nip, jmlh_kehadiran FROM kehadiran";
$result = $conn->query($sql);

$daftar_kehadiran = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['nm_staf'] = get_nama_staf($row['nip']);
        $daftar_kehadiran[] = $row;
    }
} else {
    echo "Tidak ada data kehadiran.";
}

$conn->close();
?>

<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th class="text-center align-middle">No</th>
            <th class="text-center align-middle">Nama Staf</th>
            <th class="text-center align-middle">Jumlah Kehadiran</th>
            <th class="text-center align-middle">Aksi</th>
        </tr>
    </thead>
    <tbody id="kehadiranTableBody">
        <?php
        foreach ($daftar_kehadiran as $index => $kehadiran): ?>
            <tr data-id="<?= $kehadiran['id_kehadiran']; ?>">
                <td><?= $index + 1; ?></td>
                <td><?= $kehadiran['nm_staf']; ?></td>
                <td><?= $kehadiran['jmlh_kehadiran']; ?></td>
                <td>
                    <button class="btn btn-info btn-sm edit-btn" data-id="<?= $kehadiran['id_kehadiran']; ?>" data-toggle="modal" data-target="#modalEditKehadiran">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $kehadiran['id_kehadiran']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modalEditKehadiran" tabindex="-1" role="dialog" aria-labelledby="modalEditKehadiranLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditKehadiranLabel">Edit Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-kehadiran-modal">
                    <input type="hidden" id="edit_id_kehadiran" name="id_kehadiran">
                    <div class="form-group">
                        <label for="edit_nip">Nama Staf:</label>
                        <select class="form-control" id="edit_nip" name="nip" required>
                            <option value="">Pilih Staf</option>
                            <?php
                            include 'koneksi.php';
                            $sql_staf = "SELECT nip, nm_staf FROM staf";
                            $result_staf = $conn->query($sql_staf);
                            while ($row_staf = $result_staf->fetch_assoc()) {
                                echo "<option value='{$row_staf['nip']}'>{$row_staf['nm_staf']}</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jmlh_kehadiran">Jumlah Kehadiran:</label>
                        <input type="text" class="form-control" id="edit_jmlh_kehadiran" name="jmlh_kehadiran" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-update-kehadiran">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('#kehadiranTableBody tr');
    let nomor = 1;

    tableRows.forEach(row => {
        const noCell = row.querySelector('td:first-child');
        noCell.textContent = nomor;
        nomor++;
    });

    $(document).on("click", ".edit-btn", function(){
        const row = $(this).closest("tr");
        const id = row.data("id");
        const nip = row.find("td:eq(1)").text();
        const jmlhKehadiran = row.find("td:eq(2)").text();

        $("#edit_id_kehadiran").val(id);
        $("#edit_nip").val(nip);
        $("#edit_jmlh_kehadiran").val(jmlhKehadiran);
    });

    $("#btn-update-kehadiran").click(function(){
        const formData = $("#form-edit-kehadiran-modal").serialize();

        $.ajax({
            type: "POST",
            url: "edit_kehadiran.php",
            data: formData,
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on("click", ".delete-btn", function(){
        const row = $(this).closest("tr");
        const id = row.data("id");

        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                type: "POST",
                url: "hapus_kehadiran.php",
                data: { id_kehadiran: id },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});
</script>