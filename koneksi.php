<?php
$host = "localhost";
$port = "3309";
$user = "root";
$pass = "";
$db   = "projectpwl";

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
