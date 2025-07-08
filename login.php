<?php
include 'koneksi.php';
session_start();

// Validasi input
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['message'] = 'Mohon isi username dan password.';
    header("Location: index.php");
    exit;
}

// Bersihkan input
$username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
$password = mysqli_real_escape_string($koneksi, trim($_POST['password']));

// Query pencocokan
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE BINARY TRIM(username) = '$username' AND BINARY TRIM(password) = '$password'");

if (!$query) {
    die("Query Error: " . mysqli_error($koneksi));
}

// Jika ditemukan
if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    $_SESSION['username'] = $data['username'];
    $_SESSION['role']     = $data['role'];

    // Redirect berdasarkan role
    if ($data['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } elseif ($data['role'] == 'mahasiswa') {
        header("Location: dashboard_mahasiswa.php");
    } else {
        $_SESSION['message'] = 'Role tidak dikenali.';
        header("Location: index.php");
    }
    exit;
} else {
    $_SESSION['message'] = 'Login gagal! Username atau password salah.';
    header("Location: index.php");
    exit;
}
