<!-- File: login.php (updated) -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php
require_once 'config/database.php';
require_once 'config/session.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    // Check user
    $query = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: home.php');
            exit();
        } else {
            $error = 'Password salah';
        }
    } else {
        $error = 'Username/email tidak ditemukan';
    }
    $stmt->close();
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow p-4" style="width: 360px;">
        <h3 class="text-center mb-3">Login</h3>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username atau Email</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="text-center mt-3">
                <a href="register.php">Daftar</a> |
                <a href="reset_password.php">Lupa Password?</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>