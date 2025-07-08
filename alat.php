<?php
session_start();
include 'koneksi.php';

// Hanya untuk admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Tambah alat
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "INSERT INTO alat (nama, jenis, lokasi, status) 
        VALUES ('$nama', '$jenis', '$lokasi', '$status')");

    header("Location: alat.php");
    exit;
}

// Hapus alat
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM alat WHERE id = '$id'");
    header("Location: alat.php");
    exit;
}

// Ambil semua data alat
$data = mysqli_query($koneksi, "SELECT * FROM alat");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Kelola Alat</h3>
    <a href="dashboard_admin.php" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Form Tambah -->
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="nama" class="form-control" placeholder="Nama Alat" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="jenis" class="form-control" placeholder="Jenis" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" required>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="tersedia">Tersedia</option>
                <option value="dipinjam">Dipinjam</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" name="tambah">Tambah</button>
        </div>
    </form>

    <!-- Tabel Data Alat -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr><th>No</th><th>Nama</th><th>Jenis</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($a = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $a['nama'] ?></td>
                <td><?= $a['jenis'] ?></td>
                <td><?= $a['lokasi'] ?></td>
                <td><?= $a['status'] ?></td>
                <td>
                    <a href="?hapus=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus alat ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>