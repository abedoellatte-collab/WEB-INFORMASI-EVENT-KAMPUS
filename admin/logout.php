<?php
session_start(); // Memulai sesi untuk mengakses data sesi saat ini

// 1. Menghapus semua variabel sesi
$_SESSION = [];
session_unset();

// 2. Menghancurkan sesi sepenuhnya
session_destroy();

// 3. Mengarahkan pengguna kembali ke halaman login utama
// Kita menggunakan "../" karena file ini berada di dalam folder 'admin'
header("Location: ../login.php");
exit;
?>