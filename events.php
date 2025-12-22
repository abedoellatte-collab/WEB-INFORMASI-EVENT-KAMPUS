<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event - Event Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="home.php">Event Kampus</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="events.php">Event</a></li>
                <li class="nav-item"><a class="nav-link" href="notif.php">Notifikasi</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h3 class="mb-4">Daftar Semua Event</h3>

    <div class="row g-4">

        <!-- CARD EVENT -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="assets/img/event1.jpg" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Seminar Teknologi</h5>
                    <p class="card-text">Kategori: Akademik</p>
                    <a href="event-detail.php" class="btn btn-primary w-100">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- Duplicate untuk event lainnya -->

    </div>
</div>

</body>
</html>
