<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/bg-login.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .login-box h4 {
            color: #fff;
            margin-bottom: 20px;
        }
        label {
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }
        .login-links a {
            color: #fff;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .login-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h4 class="text-center">Login Sistem Booking</h4>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-danger text-center py-2">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="mt-3 text-center login-links">
            <a href="register.php">Belum punya akun? Daftar</a> |
            <a href="lupa_password.php">Lupa password?</a>
        </div>
    </form>
</div>

</body>
</html>