<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grafik Statistik Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Grafik Statistik: Alat Paling Sering Dibooking</h3>
    <canvas id="grafikAlat" width="400" height="150"></canvas>
    <a href="dashboard_admin.php" class="btn btn-secondary mt-4">← Kembali ke Dashboard</a>
</div>

<script>
fetch('chart-data.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('grafikAlat').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.label,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: data.total,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            }
        });
    });
</script>
</body>
</html>