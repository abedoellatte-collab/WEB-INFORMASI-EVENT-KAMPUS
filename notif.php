<!-- File: notif.php (updated) -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifikasi - Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireLogin();

$user_id = getCurrentUserId();

// Mark notifications as read
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_all_read'])) {
    $update_query = "UPDATE notifications SET is_read = TRUE WHERE user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Get notifications
$query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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
                <li class="nav-item"><a class="nav-link active" href="notif.php">Notifikasi</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Notifikasi Anda</h3>
        <form method="POST" action="">
            <button type="submit" name="mark_all_read" class="btn btn-sm btn-outline-secondary">
                Tandai Semua Sudah Dibaca
            </button>
        </form>
    </div>
    
    <ul class="list-group">
        <?php
        if ($result->num_rows > 0) {
            while ($notif = $result->fetch_assoc()) {
                $class = $notif['is_read'] ? '' : 'fw-bold';
        ?>
        <li class="list-group-item <?php echo $class; ?>">
            <?php echo htmlspecialchars($notif['message']); ?>
            <small class="text-muted d-block mt-1">
                <?php echo date('d F Y H:i', strtotime($notif['created_at'])); ?>
            </small>
        </li>
        <?php
            }
        } else {
            echo '<li class="list-group-item text-center text-muted">Tidak ada notifikasi</li>';
        }
        $stmt->close();
        ?>
    </ul>
</div>
</body>
</html>