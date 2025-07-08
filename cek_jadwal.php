<?php
include 'koneksi.php';

$alat_id = $_POST['alat_id'];
$tanggal = $_POST['tanggal'];
$jam     = $_POST['jam'];

$query = mysqli_query($koneksi, "SELECT * FROM booking 
    WHERE alat_id = '$alat_id' 
    AND tanggal = '$tanggal' 
    AND jam = '$jam'");

if (mysqli_num_rows($query) > 0) {
    echo "<span style='color:red;'>❌ Tidak tersedia (sudah dibooking)</span>";
} else {
    echo "<span style='color:green;'>✅ Tersedia</span>";
}
?>