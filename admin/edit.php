<?php
session_start();
include '../db.php';

// Cek Sesi Admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM events WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']); // Dropdown
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal    = $_POST['tanggal'];
    $waktu      = $_POST['waktu'];
    $lokasi     = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $gambar_lama = $_POST['gambar_lama'];

    // Cek upload gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $gambar_baru = date('dmYHis') . '_' . $gambar; // Rename agar unik
        
        if(move_uploaded_file($tmp, "../assets/images/" . $gambar_baru)){
            if (file_exists("../assets/images/" . $gambar_lama) && $gambar_lama != '') {
                unlink("../assets/images/" . $gambar_lama);
            }
            $gambar = $gambar_baru;
        } else {
             $gambar = $gambar_lama;
        }
    }

    $sql = "UPDATE events SET 
            judul = '$judul',
            deskripsi = '$deskripsi',
            tanggal = '$tanggal',
            waktu = '$waktu',
            lokasi = '$lokasi',
            kategori = '$kategori',
            gambar = '$gambar'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diubah!'); document.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Event - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">Admin Panel - Edit Event</span>
    </div>
</nav>

<div class="container mb-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Form Edit Event</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="gambar_lama" value="<?= $data['gambar'] ?>">

                <div class="mb-3">
                    <label class="form-label">Judul Event</label>
                    <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Seminar" <?= ($data['kategori'] == 'Seminar') ? 'selected' : '' ?>>Seminar</option>
                        <option value="Lokakarya" <?= ($data['kategori'] == 'Lokakarya') ? 'selected' : '' ?>>Lokakarya</option>
                        <option value="Kompetisi" <?= ($data['kategori'] == 'Kompetisi') ? 'selected' : '' ?>>Kompetisi</option>
                        <option value="Festival" <?= ($data['kategori'] == 'Festival') ? 'selected' : '' ?>>Festival</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="5" required><?= $data['deskripsi'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waktu</label>
                        <input type="time" name="waktu" class="form-control" value="<?= $data['waktu'] ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Banner</label>
                    <div class="mb-2">
                        <img src="../assets/images/<?= $data['gambar'] ?>" width="150" class="img-thumbnail">
                        <small class="text-muted d-block">*Gambar saat ini</small>
                    </div>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <hr>
                <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>