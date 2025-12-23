<!-- File: event.php (updated) -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Event - Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php
require_once 'config/database.php';
require_once 'config/session.php';
requireLogin();

if (!isset($_GET['id'])) {
    header('Location: events.php');
    exit();
}

$event_id = intval($_GET['id']);
$query = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: events.php');
    exit();
}

$event = $result->fetch_assoc();
$remaining = $event['quota'] - $event['registered'];

// Check if user already registered
$user_id = getCurrentUserId();
$check_reg_query = "SELECT id FROM registrations WHERE user_id = ? AND event_id = ?";
$check_stmt = $conn->prepare($check_reg_query);
$check_stmt->bind_param("ii", $user_id, $event_id);
$check_stmt->execute();
$check_stmt->store_result();
$already_registered = $check_stmt->num_rows > 0;
$check_stmt->close();

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    if (!$already_registered && $remaining > 0) {
        // Register user
        $register_query = "INSERT INTO registrations (user_id, event_id) VALUES (?, ?)";
        $reg_stmt = $conn->prepare($register_query);
        $reg_stmt->bind_param("ii", $user_id, $event_id);
        
        if ($reg_stmt->execute()) {
            // Update registered count
            $update_query = "UPDATE events SET registered = registered + 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("i", $event_id);
            $update_stmt->execute();
            $update_stmt->close();
            
            // Add notification
            $message = "Anda berhasil mendaftar pada event " . $event['title'];
            $notif_query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $notif_stmt = $conn->prepare($notif_query);
            $notif_stmt->bind_param("is", $user_id, $message);
            $notif_stmt->execute();
            $notif_stmt->close();
            
            header('Location: event.php?id=' . $event_id);
            exit();
        }
        $reg_stmt->close();
    }
}
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
                <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="https://picsum.photos/600/400?random=<?php echo $event['id']; ?>" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
            <p><strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($event['event_date'])); ?></p>
            <p><strong>Tempat:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
            <p><strong>Kategori:</strong> <?php echo htmlspecialchars($event['category']); ?></p>
            <p><?php echo htmlspecialchars($event['description']); ?></p>
            
            <p><strong>Kuota:</strong> <?php echo $event['quota']; ?> peserta</p>
            <p><strong>Kuota terisi:</strong> <?php echo $event['registered']; ?> peserta</p>
            <p><strong>Sisa kuota:</strong> <?php echo $remaining; ?> peserta</p>
            
            <form method="POST" action="">
                <?php if ($already_registered): ?>
                    <button class="btn btn-secondary w-100 mt-3" disabled>Sudah Terdaftar</button>
                <?php elseif ($remaining <= 0): ?>
                    <button class="btn btn-danger w-100 mt-3" disabled>Kuota Penuh</button>
                <?php else: ?>
                    <button type="submit" name="register" class="btn btn-success w-100 mt-3">Daftar Sekarang</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>