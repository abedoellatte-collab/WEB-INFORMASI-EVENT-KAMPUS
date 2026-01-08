<?php
session_start();
include '../db.php';

// 1. Cek Keamanan: Pastikan yang mengakses adalah admin yang sudah login [cite: 11]
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

// 2. Cek apakah ada parameter ID di URL
if (isset($_GET['id'])) {
    // Ambil ID dan sanitasi untuk keamanan dasar
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. AMBIL DATA GAMBAR DULU
    // Sebelum menghapus data di database, kita perlu tahu nama file gambarnya
    // agar kita bisa menghapus file tersebut dari folder 'assets/images/'.
    // Ini penting agar server tidak penuh dengan gambar sampah (orphan files).
    $query_cek = mysqli_query($conn, "SELECT gambar FROM events WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query_cek);

    // Cek apakah datanya ditemukan
    if ($data) {
        $nama_gambar = $data['gambar'];
        $path_file = "../assets/images/" . $nama_gambar;

        // Hapus file fisik gambar jika file tersebut ada di folder
        if (file_exists($path_file) && $nama_gambar != "") {
            unlink($path_file); // Fungsi PHP untuk menghapus file
        }

        // 4. Hapus data event dari Database
        $query_hapus = mysqli_query($conn, "DELETE FROM events WHERE id = '$id'");

        if ($query_hapus) {
            // Jika berhasil, tampilkan alert dan kembali ke dashboard
            echo "<script>
                    alert('Data event berhasil dihapus!');
                    document.location.href = 'index.php';
                  </script>";
        } else {
            echo "Gagal menghapus data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
                alert('Data tidak ditemukan!');
                document.location.href = 'index.php';
              </script>";
    }
} else {
    // Jika tidak ada ID, kembalikan ke index
    header("Location: index.php");
}
?>