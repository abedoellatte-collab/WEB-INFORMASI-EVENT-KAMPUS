<?php
session_start();
require_once 'db.php';

/**
 * Proses login admin dengan verifikasi kredensial
 * 
 * @param mysqli $koneksi Koneksi database
 * @param string $username Username input
 * @param string $password Password input
 * @return array|bool Mengembalikan data user jika berhasil, false jika gagal
 */
function prosesLoginAdmin($koneksi, $username, $password) {
    $usernameAman = mysqli_real_escape_string($koneksi, trim($username));
    
    try {
        $kueri = "SELECT * FROM admin WHERE username = '$usernameAman'";
        $hasil = mysqli_query($koneksi, $kueri);
        
        if (!$hasil) {
            throw new Exception("Kesalahan kueri database: " . mysqli_error($koneksi));
        }
        
        if (mysqli_num_rows($hasil) !== 1) {
            return false;
        }
        
        $dataUser = mysqli_fetch_assoc($hasil);
        
        if (password_verify($password, $dataUser['password'])) {
            return $dataUser;
        }
        
        return false;
        
    } catch (Exception $e) {
        error_log("Login Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Tampilkan pesan error
 * 
 * @param string $pesan Pesan error yang akan ditampilkan
 */
function tampilkanError($pesan) {
    echo '<div class="alert alert-danger text-center p-2 small">' . htmlspecialchars($pesan) . '</div>';
}

// Proses form login jika disubmit
$pesanError = null;
$berhasilLogin = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $usernameInput = $_POST['username'] ?? '';
    $passwordInput = $_POST['password'] ?? '';
    
    if (empty($usernameInput) || empty($passwordInput)) {
        $pesanError = "Username dan password harus diisi!";
    } else {
        $dataAdmin = prosesLoginAdmin($conn, $usernameInput, $passwordInput);
        
        if ($dataAdmin) {
            $_SESSION['admin'] = true;
            $_SESSION['admin_id'] = $dataAdmin['id'];
            $_SESSION['admin_username'] = $dataAdmin['username'];
            
            header("Location: admin/index.php");
            exit();
        } else {
            $pesanError = "Username atau password salah!";
        }
    }
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
        body {
            background-color: #121212;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card-login {
            background-color: #1e1e1e;
            border: 1px solid #333;
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .form-control {
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: white;
        }
        .form-control:focus {
            background-color: #2a2a2a;
            color: white;
            border-color: #00e676;
            box-shadow: 0 0 0 0.25rem rgba(0, 230, 118, 0.25);
        }
        .btn-fantasy {
            background-color: #00e676;
            color: #000;
            font-weight: 600;
            width: 100%;
            border: none;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .btn-fantasy:hover {
            background-color: #00c853;
        }
        .link-kembali {
            color: #888;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.3s;
        }
        .link-kembali:hover {
            color: #00e676;
        }
    </style>
</head>
<body>
    <div class="card-login">
        <h3 class="text-center mb-4" style="color: #00e676;">Admin Login</h3>
        
        <?php if ($pesanError): ?>
            <?php tampilkanError($pesanError); ?>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label text-secondary small">Username</label>
                <input type="text" 
                       name="username" 
                       class="form-control" 
                       required 
                       autocomplete="off"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            
            <div class="mb-4">
                <label class="form-label text-secondary small">Password</label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       required>
            </div>
            
            <button type="submit" 
                    name="login" 
                    class="btn btn-fantasy">
                MASUK
            </button>
            
            <div class="text-center mt-3">
                <a href="index.php" class="link-kembali">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>
</body>
</html>