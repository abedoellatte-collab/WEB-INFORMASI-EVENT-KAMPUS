<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Event Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow p-4" style="width: 360px;">
        <h3 class="text-center mb-3">Reset Password</h3>

        <form action="#" method="POST">

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Reset Password</button>

            <p class="text-center mt-3">
                <a href="login.php">Kembali ke Login</a>
            </p>

        </form>
    </div>
</div>
<!-- File: reset_password.php (updated) -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($username) || empty($new_password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Password baru dan konfirmasi tidak cocok';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password minimal 6 karakter';
    } else {
        // Check if user exists
        $check_query = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            $error = 'Username tidak ditemukan';
        } else {
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $hashed_password, $username);
            
            if ($update_stmt->execute()) {
                $success = 'Password berhasil direset! Silakan login.';
                header("refresh:2;url=login.php");
            } else {
                $error = 'Terjadi kesalahan: ' . $update_stmt->error;
            }
            $update_stmt->close();
        }
        $stmt->close();
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow p-4" style="width: 360px;">
        <h3 class="text-center mb-3">Reset Password</h3>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>

            <p class="text-center mt-3">
                <a href="login.php">Kembali ke Login</a>
            </p>
        </form>
    </div>
</div>
</body>
</html>
</body>
</html>
