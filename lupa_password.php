<?php
$conn = new mysqli("localhost", "root", "", "projectpwl", 3309);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];

    $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE users SET password='$newPassword' WHERE username='$username'");
        echo "<script>alert('Password berhasil diubah. Silakan login.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="reset-box">
        <h4 class="text-center">Reset Password</h4>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>

</body>

</html>