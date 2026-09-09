<?php
require 'config.php';
requireLogin();

$announcements = $database->query('SELECT * FROM announcements ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Announcements | Peace Freedom</title>
</head>
<body class="dashboard-page">
    <main class="board-shell">
        <header class="board-header">
            <div>
                <p class="eyebrow">Peace Freedom International Collective</p>
                <h1>Announcement Board</h1>
                <p class="header-copy">Latest updates and notices.</p>
            </div>
            <nav class="board-actions" aria-label="Dashboard actions">
                <a class="logout" href="logout.php">Logout</a>
            </nav>
        </header>

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
    </main>
</body>
</html>
