<?php
include 'db.php';

$username = 'abdul';
$password_baru = 'abdul123';

$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

$cek = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

if (mysqli_num_rows($cek) > 0) {
    $query = "UPDATE admin SET password = '$password_hash' WHERE username = '$username'";
    mysqli_query($conn, $query);
    echo "<h1>BERHASIL DI-UPDATE!</h1>";
} else {
    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password_hash')";
    mysqli_query($conn, $query);
    echo "<h1>BERHASIL DIBUAT BARU!</h1>";
}

echo "<p>Username: <b>$username</b></p>";
echo "<p>Password: <b>$password_baru</b></p>";
echo "<br><a href='login.php'>Klik disini untuk Login</a>";
?>