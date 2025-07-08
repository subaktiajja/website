<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$totalBooking = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM booking"));
$totalAlat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM alat"));
$totalUser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE role='mahasiswa'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card-hover:hover {
            transform: scale(1.02);
            transition: 0.2s ease-in-out;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white min-vh-100 p-3">
            <h4>Admin Panel</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard_admin.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="grafik.php" class="nav-link text-white">Grafik</a></li>
                <li class="nav-item"><a href="alat.php" class="nav-link text-white">Kelola Alat</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
            </ul>
        </div>

        <!-- Konten -->
        <div class="col-md-10 p-4">
            <h2>Dashboard Admin</h2>
            <div class="row mb-4">
                <div class="col-md-4">
                    <a href="booking.php" class="text-decoration-none">
                        <div class="card bg-primary text-white card-hover">
                            <div class="card-body">
                                <h5>Total Booking</h5>
                                <p class="fs-4"><?= $totalBooking ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="alat.php" class="text-decoration-none">
                        <div class="card bg-success text-white card-hover">
                            <div class="card-body">
                                <h5>Total Alat</h5>
                                <p class="fs-4"><?= $totalAlat ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="mahasiswa_list.php" class="text-decoration-none">
                        <div class="card bg-warning text-white card-hover">
                            <div class="card-body">
                                <h5>Total Mahasiswa</h5>
                                <p class="fs-4"><?= $totalUser ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Filter Booking -->
            <form id="filterForm" class="row g-3 mb-3">
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" placeholder="Tanggal">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>

            <!-- Hasil Filter Booking -->
            <div id="hasilBooking"></div>

            <!-- Jadwal Hari Ini -->
            <hr class="mt-5 mb-3">
            <h4>📅 Jadwal Booking Hari Ini</h4>
            <?php
            $today = date('Y-m-d');
            $jadwal = mysqli_query($koneksi, "
                SELECT b.*, a.nama AS alat_nama, u.username 
                FROM booking b 
                JOIN alat a ON b.alat_id = a.id 
                JOIN users u ON b.username = u.username 
                WHERE b.tanggal = '$today'
                ORDER BY b.jam ASC
            ");
            ?>
            <table class="table table-sm table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Alat</th>
                        <th>Jam</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($j = mysqli_fetch_assoc($jadwal)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $j['username'] ?></td>
                        <td><?= $j['alat_nama'] ?></td>
                        <td><?= $j['jam'] ?></td>
                        <td><?= $j['keperluan'] ?></td>
                        <td><?= $j['status'] ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($no == 1): ?>
                    <tr><td colspan="6" class="text-center text-muted">Tidak ada jadwal hari ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    muatBooking();

    $('#filterForm').submit(function(e) {
        e.preventDefault();
        muatBooking();
    });

    function muatBooking() {
        var formData = $('#filterForm').serialize();
        $.post('filter_booking.php', formData, function(data) {
            $('#hasilBooking').html(data);
        });
    }
});
</script>
</body>
</html>