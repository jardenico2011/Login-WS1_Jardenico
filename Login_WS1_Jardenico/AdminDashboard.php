<?php
require 'config.php';
requireLogin();
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? 'General';
    $message = trim($_POST['message'] ?? '');
    $allowedCategories = ['General', 'Event', 'Important'];

    if ($title && $message && in_array($category, $allowedCategories)) {
        $statement = $database->prepare('INSERT INTO announcements (title, category, message) VALUES (?, ?, ?)');
        $statement->execute([$title, $category, $message]);
    }

    header('Location: AdminDashboard.php');
    exit;
}

$announcements = $database->query('SELECT * FROM announcements ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard | Peace Freedom</title>
</head>
<body class="dashboard-page">
    <main class="board-shell">
        <header class="board-header">
            <div>
                <p class="eyebrow">Peace Freedom International Collective</p>
                <h1>Admin Dashboard</h1>
                <p class="header-copy">Create announcements for members.</p>
            </div>
            <nav class="board-actions">
                <a class="admin-link" href="Userdashboard.php">Member view</a>
                <a class="logout" href="logout.php">Logout</a>
            </nav>
        </header>

        <div class="admin-layout">
            <section class="post-form">
                <h2>New announcement</h2>
                <form action="AdminDashboard.php" method="post">
                    <label for="announcement-title">Title</label>
                    <input id="announcement-title" name="title" type="text" required>

                    <label for="announcement-category">Category</label>
                    <select id="announcement-category" name="category">
                        <option value="General">General</option>
                        <option value="Event">Event</option>
                        <option value="Important">Important</option>
                    </select>

                    <label for="announcement-message">Message</label>
                    <textarea id="announcement-message" name="message" required></textarea>

                    <button type="submit">Publish announcement</button>
                </form>
            </section>

            <section class="admin-announcements">
                <h2>Published announcements</h2>
                <section class="announcement-list">
                    <?php foreach ($announcements as $announcement): ?>
                        <article class="announcement-card">
                            <div class="announcement-meta">
                                <span class="badge <?php echo strtolower(e($announcement['category'])); ?>">
                                    <?php echo e($announcement['category']); ?>
                                </span>
                                <time><?php echo date('F j, Y', strtotime($announcement['created_at'])); ?></time>
                            </div>
                            <h2><?php echo e($announcement['title']); ?></h2>
                            <p><?php echo nl2br(e($announcement['message'])); ?></p>
                        </article>
                    <?php endforeach; ?>
                </section>
            </section>
        </div>
    </main>
</body>
</html>
