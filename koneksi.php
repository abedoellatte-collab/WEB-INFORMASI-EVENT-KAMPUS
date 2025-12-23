<!-- File: config/database.php -->
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'event_kampus';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>