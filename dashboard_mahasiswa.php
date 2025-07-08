<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

$data = mysqli_query($koneksi, "
    SELECT b.*, a.nama AS nama_alat
    FROM booking b 
    JOIN alat a ON b.alat_id = a.id 
    WHERE b.username = '$username'
    ORDER BY b.tanggal DESC, b.jam DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
        }
        .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white sidebar p-3">
            <h4 class="text-center">Mahasiswa</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard_mahasiswa.php" class="nav-link text-white active">Dashboard</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="alert alert-primary">👋 Selamat Datang, <strong><?= htmlspecialchars($username) ?></strong></div>

            <!-- Form Booking -->
            <div class="card mb-4 shadow">
                <div class="card-header bg-primary text-white">Form Booking Alat</div>
                <div class="card-body">
                    <form action="proses_booking.php" method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Alat</label>
                                <select name="alat_id" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <?php
                                    $alat = mysqli_query($koneksi, "SELECT * FROM alat");
                                    while ($a = mysqli_fetch_assoc($alat)) {
                                        echo "<option value='{$a['id']}'>{$a['nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jam</label>
                                <input type="time" name="jam" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keperluan</label>
                            <input type="text" name="keperluan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Dokumen (PDF/JPG/PNG)</label>
                            <input type="file" name="dokumen" class="form-control" accept=".pdf,.jpg,.png" required>
                        </div>

                        <button type="submit" class="btn btn-success">📥 Submit Booking</button>
                    </form>
                </div>
            </div>

            <!-- Riwayat Booking -->
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">📋 Riwayat Booking Anda</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover table-sm align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Alat</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Keperluan</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($data)) {
                                echo "<tr class='text-center'>
                                    <td>{$no}</td>
                                    <td>{$row['nama_alat']}</td>
                                    <td>{$row['tanggal']}</td>
                                    <td>{$row['jam']}</td>
                                    <td>{$row['keperluan']}</td>
                                    <td><span class='badge bg-" . 
                                        ($row['status'] == 'Disetujui' ? 'success' : ($row['status'] == 'Ditolak' ? 'danger' : 'warning')) . 
                                        "'>{$row['status']}</span></td>
                                    <td><a href='upload/{$row['dokumen']}' class='btn btn-sm btn-info' target='_blank'>Lihat</a></td>
                                    <td><a href='cetak_bukti.php?id={$row['id']}' class='btn btn-sm btn-secondary' target='_blank'>🖨️ Cetak</a></td>
                                </tr>";
                                $no++;
                            }
                            if ($no == 1) {
                                echo "<tr><td colspan='8' class='text-center text-muted'>Belum ada data booking.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>