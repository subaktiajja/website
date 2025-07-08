<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

$alat = mysqli_query($koneksi, "SELECT * FROM alat WHERE status='tersedia'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Form Booking Alat</h3>
    <a href="dashboard_mahasiswa.php" class="btn btn-secondary mb-3">Kembali</a>

    <form action="proses_booking.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Alat:</label>
            <select name="alat_id" class="form-select" required>
                <option value="">-- Pilih Alat --</option>
                <?php while ($a = mysqli_fetch_assoc($alat)) { ?>
                    <option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam:</label>
            <input type="time" name="jam" class="form-control" required>
        </div>

        <div id="hasilCek" class="mb-3 text-info"></div>

        <div class="mb-3">
            <label>Keperluan:</label>
            <textarea name="keperluan" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Upload Dokumen:</label>
            <input type="file" name="dokumen" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Booking</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('input[name=tanggal], input[name=jam], select[name=alat_id]').on('change', function() {
    var alat = $('select[name=alat_id]').val();
    var tanggal = $('input[name=tanggal]').val();
    var jam = $('input[name=jam]').val();
    if (alat && tanggal && jam) {
        $.post('cek_jadwal.php', {
            alat_id: alat,
            tanggal: tanggal,
            jam: jam
        }, function(data) {
            $('#hasilCek').html(data);
        });
    }
});
</script>
</body>
</html>