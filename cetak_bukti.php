<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "❌ ID tidak diberikan.";
    exit;
}

$id = $_GET['id'];
$username = $_SESSION['username'];

$q = mysqli_query($koneksi, "
    SELECT b.*, a.nama AS alat_nama, a.lokasi, a.jenis 
    FROM booking b 
    JOIN alat a ON b.alat_id = a.id 
    WHERE b.id = '$id' AND b.username = '$username'
");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "❌ Data tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .btn-cetak { display: none; }
        }
        body {
            padding: 40px;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }
        .table td {
            vertical-align: top;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Bukti Booking Alat</h2>
    <hr>

    <table class="table table-bordered">
        <tr>
            <th width="30%">Nama Mahasiswa</th>
            <td><?= htmlspecialchars($data['username']) ?></td>
        </tr>
        <tr>
            <th>Nama Alat</th>
            <td><?= htmlspecialchars($data['alat_nama']) ?></td>
        </tr>
        <tr>
            <th>Jenis</th>
            <td><?= htmlspecialchars($data['jenis']) ?></td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td><?= htmlspecialchars($data['lokasi']) ?></td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td><?= htmlspecialchars($data['tanggal']) ?></td>
        </tr>
        <tr>
            <th>Jam</th>
            <td><?= htmlspecialchars($data['jam']) ?></td>
        </tr>
        <tr>
            <th>Keperluan</th>
            <td><?= htmlspecialchars($data['keperluan']) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge bg-<?= $data['status'] == 'Disetujui' ? 'success' : ($data['status'] == 'Ditolak' ? 'danger' : 'warning') ?>">
                    <?= htmlspecialchars($data['status']) ?>
                </span>
            </td>
        </tr>
        <tr>
            <th>Dokumen</th>
            <td>
                <?php if (!empty($data['dokumen'])): ?>
                    <a href="upload/<?= htmlspecialchars($data['dokumen']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat Dokumen</a>
                <?php else: ?>
                    <span class="text-muted">Tidak ada dokumen</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="btn-cetak text-center mt-4 d-flex justify-content-center gap-3">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Bukti</button>
        <a href="dashboard_mahasiswa.php" class="btn btn-secondary">❌ Cancel</a>
    </div>
</div>

</body>
</html>