<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$aksi = $_GET['aksi'];

$status = ($aksi == 'setujui') ? 'Disetujui' : 'Ditolak';
$admin = $_SESSION['username'];
$waktu = date("Y-m-d H:i:s");

mysqli_query($koneksi, "UPDATE booking SET status='$status' WHERE id='$id'");

mysqli_query($koneksi, "INSERT INTO verifikasi_admin (booking_id, admin_username, waktu_verifikasi, status)
VALUES ('$id', '$admin', '$waktu', '$status')");

header("Location: dashboard_admin.php");
exit;
?>