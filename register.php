<?php
$conn = new mysqli("localhost", "root", "", "projectpwl", 3309);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];
    $email    = $_POST['email'];
    $nama     = $_POST['nama'];

    // Cek apakah username sudah digunakan
    $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan'); window.location='register.php';</script>";
    } else {
        $conn->query("INSERT INTO users (username, password, role, email, nama) VALUES ('$username', '$password', '$role', '$email', '$nama')");
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        label {
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="register-box">
        <h4 class="text-center">Daftar Akun Baru</h4>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary">Daftar</button>
            </div>
        </form>
    </div>

</body>

</html>