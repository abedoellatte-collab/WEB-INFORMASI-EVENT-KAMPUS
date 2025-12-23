<!-- File: profile.php (updated) -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil - Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireLogin();

$user_id = getCurrentUserId();

// Get user info
$query = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Get user's registered events count
$event_query = "SELECT COUNT(*) as event_count FROM registrations WHERE user_id = ?";
$event_stmt = $conn->prepare($event_query);
$event_stmt->bind_param("i", $user_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_count = $event_result->fetch_assoc()['event_count'];
$event_stmt->close();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="home.php">Event Kampus</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="events.php">Event</a></li>
                <li class="nav-item"><a class="nav-link" href="notif.php">Notifikasi</a></li>
                <li class="nav-item"><a class="nav-link active" href="profile.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow p-4" style="max-width: 400px; margin: auto;">
        <div class="text-center">
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['username']); ?>&background=random&size=128" 
                 class="rounded-circle mb-3" width="120">
            <h4><?php echo htmlspecialchars($user['username']); ?></h4>
            <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
            <p class="text-muted">Member sejak: <?php echo date('d F Y', strtotime($user['created_at'])); ?></p>
            <p class="text-muted">Event yang diikuti: <?php echo $event_count; ?></p>
        </div>
        <a href="logout.php" class="btn btn-danger mt-3 w-100">Logout</a>
    </div>
</div>
</body>
</html>