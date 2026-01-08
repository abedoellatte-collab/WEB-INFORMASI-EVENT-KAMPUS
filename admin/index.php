<?php
session_start();
include '../db.php';
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit; }

$query = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Admin Panel</span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Kelola Event</h3>
        <a href="tambah.php" class="btn btn-success mb-3">+ Tambah Event</a>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['judul'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['lokasi'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>