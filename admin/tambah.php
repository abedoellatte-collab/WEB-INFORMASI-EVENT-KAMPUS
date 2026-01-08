<?php
session_start();
include '../db.php';

// Cek sesi admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']); // Data diambil dari dropdown

    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    
    // Rename gambar agar unik (opsional, tapi disarankan)
    $gambar_baru = date('dmYHis') . '_' . $gambar;
    
    if(move_uploaded_file($tmp, "../assets/images/" . $gambar_baru)){
        $sql = "INSERT INTO events (judul, deskripsi, tanggal, waktu, lokasi, kategori, gambar) 
                VALUES ('$judul', '$deskripsi', '$tanggal', '$waktu', '$lokasi', '$kategori', '$gambar_baru')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Event berhasil ditambahkan!'); window.location='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Gagal upload gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">Admin Panel - Tambah Event</span>
    </div>
</nav>

<div class="container mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Tambah Event Baru</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label">Judul Event</label>
                    <input type="text" name="judul" class="form-control" required placeholder="Contoh: Seminar Teknologi 2025">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Seminar">Seminar</option>
                        <option value="Lokakarya">Lokakarya</option>
                        <option value="Kompetisi">Kompetisi</option>
                        <option value="Festival">Festival</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Jelaskan detail acaranya..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waktu</label>
                        <input type="time" name="waktu" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" required placeholder="Contoh: Aula Gedung B">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Banner</label>
                    <input type="file" name="gambar" class="form-control" required accept="image/*">
                    <div class="form-text">Format: JPG, PNG, JPEG.</div>
                </div>

                <hr>
                <button type="submit" name="submit" class="btn btn-success">Simpan Event</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>