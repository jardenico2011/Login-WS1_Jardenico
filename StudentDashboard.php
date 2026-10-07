<?php
require 'config.php';

requireLogin();
requireStudent();

$announcements = $database
    ->query('SELECT * FROM announcements ORDER BY id DESC')
    ->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student Dashboard | ANNOUNCEMENT PAGE</title>
</head>

<body class="dashboard-page">

    <main class="board-shell">

        <header class="board-header">
            <div>
                <p class="eyebrow">ANNOUNCEMENT PAGE</p>

                <h1>Student Dashboard</h1>

                <p class="header-copy">
                    Welcome, <?= e($_SESSION['user']['name']) ?>.
                    Stay updated with the latest notices.
                </p>
            </div>

            <nav class="board-actions">
                <a class="logout" href="logout.php">Logout</a>
            </nav>
        </header>

        <section class="announcement-list">

            <?php if (empty($announcements)): ?>

                <p class="header-copy">
                    No announcements available.
                </p>

            <?php else: ?>

                <?php foreach ($announcements as $announcement): ?>

                    <article class="announcement-card">

                        <div class="announcement-meta">

                            <span class="badge">
                                <?= e($announcement['category']) ?>
                            </span>

                            <time>
                                <?= e(date('F d, Y', strtotime($announcement['created_at']))) ?>
                            </time>

                        </div>

                        <h2>
                            <?= e($announcement['title']) ?>
                        </h2>

                        <p>
                            <?= nl2br(e($announcement['message'])) ?>
                        </p>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </main>

</body>
</html>