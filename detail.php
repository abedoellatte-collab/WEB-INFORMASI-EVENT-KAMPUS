<?php
include 'db.php';

// Cek ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM events WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Event tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?> - Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-green: #00e676;
            --dark-bg: #121212;
            --card-bg: #1e1e1e;
            --text-grey: #b0b0b0;
        }

        body {
            background-color: var(--dark-bg);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: rgba(18, 18, 18, 0.95);
            border-bottom: 1px solid #333;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-green) !important;
            letter-spacing: 1px;
        }

        .btn-outline-fantasy {
            color: var(--primary-green);
            border: 1px solid var(--primary-green);
            border-radius: 8px;
            padding: 8px 20px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-outline-fantasy:hover {
            background-color: var(--primary-green);
            color: #000;
            box-shadow: 0 0 15px rgba(0, 230, 118, 0.3);
        }

        /* Layout Detail */
        .detail-card {
            background-color: var(--card-bg);
            border: 1px solid #333;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            margin-top: 20px;
        }

        .event-image {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: contain;
            background-color: #000;
            border-bottom: 1px solid #333;
            display: block;
            margin: 0 auto;
        }

        .category-badge {
            background-color: rgba(0, 230, 118, 0.1);
            color: var(--primary-green);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid rgba(0, 230, 118, 0.3);
            display: inline-block;
            margin-bottom: 15px;
        }

        .meta-box {
            background-color: #252525;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #333;
            height: 100%;
        }
        .meta-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .meta-item i {
            font-size: 1.5rem;
            color: var(--primary-green);
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }
        .meta-item div {
            font-size: 0.95rem;
        }
        .meta-label {
            color: var(--text-grey);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .meta-value {
            color: white;
            font-weight: 500;
        }

        .description-text {
            color: #d1d1d1;
            line-height: 1.8;
            font-size: 1.05rem;
            white-space: pre-line; /* Agar enter/paragraf terbaca */
        }

        footer {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding: 30px 0;
            color: var(--text-grey);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-calendar4-event"></i> EVENT KAMPUS
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <a href="index.php" class="btn-outline-fantasy mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="detail-card">
            <img src="assets/images/<?= $data['gambar'] ?>" class="event-image" alt="<?= $data['judul'] ?>">

            <div class="card-body p-4 p-md-5">
                <div class="row">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <span class="category-badge"><?= $data['kategori'] ?></span>
                        <h1 class="display-5 fw-bold mb-4"><?= $data['judul'] ?></h1>
                        
                        <h5 class="text-white mb-3 border-start border-4 border-success ps-3" style="border-color: var(--primary-green) !important;">Deskripsi Event</h5>
                        <div class="description-text">
                            <?= $data['deskripsi'] ?>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="meta-box">
                            <h5 class="mb-4 text-white">Informasi Pelaksanaan</h5>
                            
                            <div class="meta-item">
                                <i class="bi bi-calendar-event"></i>
                                <div>
                                    <div class="meta-label">Tanggal</div>
                                    <div class="meta-value"><?= date('d F Y', strtotime($data['tanggal'])) ?></div>
                                </div>
                            </div>

                            <div class="meta-item">
                                <i class="bi bi-clock"></i>
                                <div>
                                    <div class="meta-label">Waktu</div>
                                    <div class="meta-value"><?= substr($data['waktu'], 0, 5) ?> WIB</div>
                                </div>
                            </div>

                            <div class="meta-item">
                                <i class="bi bi-geo-alt"></i>
                                <div>
                                    <div class="meta-label">Lokasi</div>
                                    <div class="meta-value"><?= $data['lokasi'] ?></div>
                                </div>
                            </div>

                            <hr class="border-secondary my-4">
                            
                            <div class="text-center">
                                <p class="small text-muted mb-2">Tertarik mengikuti event ini?</p>
                                <button class="btn btn-success w-100 fw-bold py-2" style="background-color: var(--primary-green); color: black; border: none;">
                                    Catat Tanggalnya!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0 small">&copy; <?= date('Y') ?> Event Kampus. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>