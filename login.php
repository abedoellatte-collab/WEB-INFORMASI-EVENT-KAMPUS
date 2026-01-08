<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Password mentah dari inputan

    // 1. Cari user berdasarkan username saja
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    
    // 2. Cek apakah username ditemukan
    if (mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        
        // 3. Cek password hash
        // password_verify(password_inputan, password_dari_database)
        if (password_verify($password, $row['password'])) {
            // Login Berhasil
            $_SESSION['admin'] = true;
            header("Location: admin/index.php");
            exit;
        }
    }
    
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #121212; color: #fff; font-family: 'Poppins', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card-login { background-color: #1e1e1e; border: 1px solid #333; width: 100%; max-width: 400px; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .form-control { background-color: #2a2a2a; border: 1px solid #444; color: white; }
        .form-control:focus { background-color: #2a2a2a; color: white; border-color: #00e676; box-shadow: 0 0 0 0.25rem rgba(0, 230, 118, 0.25); }
        .btn-fantasy { background-color: #00e676; color: #000; font-weight: 600; width: 100%; border: none; padding: 10px; border-radius: 8px; }
        .btn-fantasy:hover { background-color: #00c853; }
    </style>
</head>
<body>
    <div class="card-login">
        <h3 class="text-center mb-4" style="color: #00e676;">Admin Login</h3>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center p-2 small"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label text-secondary small">Username</label>
                <input type="text" name="username" class="form-control" required autocomplete="off">
            </div>
            <div class="mb-4">
                <label class="form-label text-secondary small">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-fantasy">MASUK</button>
            <div class="text-center mt-3">
                <a href="index.php" class="text-secondary small text-decoration-none">&larr; Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</body>
</html>