<?php
include 'koneksi.php';

// Query to fetch gaji data from database
$sql = "SELECT g.no_slipgaji, s.nm_staf, g.tgl_gaji, g.gaji_kotor, g.gaji_bersih, g.status 
        FROM gaji g
        INNER JOIN staf s ON g.nip = s.nip";
$result = $conn->query($sql);

$daftar_gaji = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $daftar_gaji[] = $row;
    }
}
?>

<!-- Table to display gaji data -->
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>No. Slip Gaji</th>
            <th>Nama Staf</th>
            <th>Tanggal Gaji</th>
            <th>Gaji Kotor</th>
            <th>Gaji Bersih</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="gajiTableBody">
        <?php foreach ($daftar_gaji as $index => $gaji): ?>
            <tr data-id="<?= $gaji['no_slipgaji']; ?>">
                <td><?= $index + 1; ?></td>
                <td><?= $gaji['no_slipgaji']; ?></td>
                <td><?= $gaji['nm_staf']; ?></td>
                <td><?= $gaji['tgl_gaji']; ?></td>
                <td><?= number_format($gaji['gaji_kotor'], 0, ',', '.'); ?></td>
                <td><?= number_format($gaji['gaji_bersih'], 0, ',', '.'); ?></td>
                <td><?= $gaji['status']; ?></td>
                <td>
                    <button class="btn btn-info btn-sm detail-btn" data-id="<?= $gaji['no_slipgaji']; ?>">Detail</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $gaji['no_slipgaji']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready(function() {
    // Detail button click event
    $(document).on("click", ".detail-btn", function(){
        const id = $(this).data("id");
        window.location.href = `detail_gaji.php?no_slipgaji=${id}`;
    });

    // Delete button click event
    $(document).on("click", ".delete-btn", function(){
        const row = $(this).closest("tr");
        const id = row.data("id");

        if (confirm("Apakah Anda yakin ingin menghapus data gaji ini?")) {
            $.ajax({
                type: "POST",
                url: "hapus_gaji.php",
                data: { no_slipgaji: id },
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
