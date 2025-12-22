<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Event Kampus</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow p-4" style="width: 360px;">
        <h3 class="text-center mb-3">Login</h3>

        <form action="#" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" required>
            </div>

            <a href="home.php" class="btn btn-primary w-100">Login</a>

            <div class="text-center mt-3">
                <a href="register.php">Daftar</a> |
                <a href="reset_password.php">Lupa Password?</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
