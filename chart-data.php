<?php
include 'koneksi.php';

header('Content-Type: application/json');

$query = "SELECT alat.nama, COUNT(*) AS total 
          FROM booking 
          JOIN alat ON booking.alat_id = alat.id 
          GROUP BY booking.alat_id";

$result = mysqli_query($koneksi, $query);

$label = [];
$total = [];

while ($row = mysqli_fetch_assoc($result)) {
    $label[] = $row['nama'];
    $total[] = (int) $row['total'];
}

echo json_encode([
    'label' => $label,
    'total' => $total
]);
?>