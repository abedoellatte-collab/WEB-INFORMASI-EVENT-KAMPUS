<?php
include 'db.php';

// Logika Pencarian
$where = "";
$search_keyword = "";
if (isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $where = "WHERE judul LIKE '%$q%' OR kategori LIKE '%$q%'";
    $search_keyword = $_GET['q'];
}

$query = mysqli_query($conn, "SELECT * FROM events $where ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-green: #00e676; /* Hijau terang tapi elegan */
            --dark-bg: #121212;       /* Hitam Matte */
            --card-bg: #1e1e1e;       /* Abu gelap untuk kartu */
            --text-grey: #b0b0b0;
        }

        body {
            background-color: var(--dark-bg);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Sederhana */
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
            border-color: var(--primary-green);
        }
        .btn-outline-fantasy:hover {
            background-color: var(--primary-green);
            color: #000;
        }

        /* Hero Section yang Tenang */
        .hero-section {
            padding: 80px 0 50px;
            background: linear-gradient(180deg, rgba(0, 230, 118, 0.05) 0%, rgba(18, 18, 18, 0) 100%);
            border-bottom: 1px solid #2a2a2a;
            margin-bottom: 40px;
        }
        
        /* Input Pencarian Minimalis */
        .form-control-dark {
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
        }
        .form-control-dark:focus {
            background-color: #2a2a2a;
            color: white;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(0, 230, 118, 0.25);
        }
        .btn-fantasy {
            background-color: var(--primary-green);
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-fantasy:hover {
            background-color: #00c853; /* Hijau lebih gelap dikit saat hover */
            box-shadow: 0 0 15px rgba(0, 230, 118, 0.4);
        }

        /* Card Design: Dark & Clean */
        .card-dark {
            background-color: var(--card-bg);
            border: 1px solid #333;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-dark:hover {
            transform: translateY(-5px);
            border-color: var(--primary-green);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #333;
        }

        .category-tag {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .card-title {
            color: white;
            font-weight: 600;
        }

        .card-meta {
            color: var(--text-grey);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .card-meta i {
            color: var(--primary-green);
            margin-right: 5px;
        }

        .btn-link-fantasy {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-link-fantasy:hover {
            color: var(--primary-green);
            letter-spacing: 1px; /* Efek hover halus */
        }
        .btn-link-fantasy i {
            font-size: 0.8em;
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
            <div class="ms-auto">
                <a href="login.php" class="btn btn-sm btn-outline-fantasy">
                    Login Admin
                </a>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">POLIBATAM EVENT</h1>
            <p class="lead text-secondary mb-4">Jangan lewatkan event seru di sekitarmu! Temukan, jadwalkan, dan hadir di berbagai acara menarik yang ada di KAMPUS.</p>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="" method="GET" class="d-flex gap-2">
                        <input type="text" name="q" class="form-control form-control-dark" 
                               placeholder="Cari event..." value="<?= $search_keyword ?>">
                        <button type="submit" class="btn btn-fantasy">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <div style="width: 5px; height: 30px; background-color: var(--primary-green); margin-right: 15px;"></div>
            <h3 class="mb-0 fw-bold">Event Terbaru</h3>
        </div>

        <?php if(!empty($search_keyword)): ?>
            <p class="text-secondary mb-4">Hasil pencarian untuk: <strong class="text-white">"<?= htmlspecialchars($search_keyword) ?>"</strong></p>
        <?php endif; ?>

        <div class="row g-4">
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card card-dark h-100">
                        <div class="position-relative">
                            <img src="assets/images/<?= $row['gambar'] ?>" class="card-img-top" alt="<?= $row['judul'] ?>">
                            <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                <small class="text-white ms-2">
                                    <i class="bi bi-calendar-check"></i> <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                </small>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <span class="category-tag"><?= $row['kategori'] ?></span>
                            <h5 class="card-title"><?= $row['judul'] ?></h5>
                            
                            <div class="card-meta">
                                <div><i class="bi bi-clock"></i> <?= substr($row['waktu'], 0, 5) ?> WIB</div>
                                <div><i class="bi bi-geo-alt"></i> <?= $row['lokasi'] ?></div>
                            </div>

                            <p class="card-text text-secondary small flex-grow-1">
                                <?= substr($row['deskripsi'], 0, 90) ?>...
                            </p>

                            <div class="mt-3 pt-3 border-top border-secondary">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn-link-fantasy d-block w-100 text-end">
                                    LIHAT DETAIL <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-secondary">Tidak ada event yang ditemukan.</h5>
                    <a href="index.php" class="btn btn-outline-fantasy mt-3">Reset Pencarian</a>
                </div>
            <?php endif; ?>
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