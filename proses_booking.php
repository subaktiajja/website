<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: index.php");
    exit;
}

$username   = $_SESSION['username'];
$alat_id    = $_POST['alat_id'];
$tanggal    = $_POST['tanggal'];
$jam        = $_POST['jam'];
$keperluan  = $_POST['keperluan'];

$dokumen    = $_FILES['dokumen']['name'];
$tmp_file   = $_FILES['dokumen']['tmp_name'];

$upload_dir = "upload/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

move_uploaded_file($tmp_file, $upload_dir . $dokumen);

mysqli_query($koneksi, "INSERT INTO booking 
    (username, alat_id, tanggal, jam, keperluan, dokumen, status) 
    VALUES 
    ('$username', '$alat_id', '$tanggal', '$jam', '$keperluan', '$dokumen', 'Menunggu')");

header("Location: dashboard_mahasiswa.php");
exit;
?>