<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$mahasiswa = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'mahasiswa'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">📚 Daftar Mahasiswa</h2>
    <a href="dashboard_admin.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($mahasiswa)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
            </tr>
            <?php endwhile; ?>
            <?php if ($no == 1): ?>
            <tr><td colspan="4" class="text-center text-muted">Belum ada mahasiswa terdaftar.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>