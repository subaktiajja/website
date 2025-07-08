<?php
include 'koneksi.php';

$q = mysqli_query($koneksi, "
    SELECT a.nama, COUNT(b.id) AS total 
    FROM booking b 
    JOIN alat a ON b.alat_id = a.id 
    GROUP BY b.alat_id 
    ORDER BY total DESC
");

$label = [];
$total = [];

while ($row = mysqli_fetch_assoc($q)) {
    $label[] = $row['nama'];
    $total[] = $row['total'];
}

echo json_encode(['label' => $label, 'total' => $total]);
?>