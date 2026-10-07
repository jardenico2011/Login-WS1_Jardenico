<?php
require 'config.php';
requireLogin();
requireAdmin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? 'General';
    $message = trim($_POST['message'] ?? '');

    $allowedCategories = ['General', 'Event', 'Important'];

    if ($title === '' || $message === '') {
        $error = 'Please enter a title and message.';
    } elseif (!in_array($category, $allowedCategories, true)) {
        $error = 'Invalid category.';
    } else {
        try {
            $statement = $database->prepare(
                'INSERT INTO announcements (title, category, message, created_at)
                 VALUES (?, ?, ?, NOW())'
            );

            $statement->execute([
                $title,
                $category,
                $message
            ]);

            header('Location: AdminDashboard.php');
            exit;

        } catch (PDOException $exception) {
            $error = 'Database error: ' . $exception->getMessage();
        }
    }
}

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
    <title>Admin Dashboard | ANNOUNCEMENT PAGE</title>
</head>

<body class="dashboard-page">

<main class="board-shell">

    <header class="board-header">
        <div>
            <p class="eyebrow">ANNOUNCEMENT PAGE</p>
            <h1>Admin Dashboard</h1>
            <p class="header-copy">
                Create announcements for students and teachers.
            </p>
        </div>

        <nav class="board-actions">
            <a class="admin-link" href="Userdashboard.php">
                Announcement view
            </a>

            <a class="logout" href="logout.php">
                Logout
            </a>
        </nav>
    </header>

    <div class="admin-layout">

        <section class="post-form">

            <h2>New announcement</h2>

            <?php if ($error): ?>
                <p class="error-message">
                    <?php echo e($error); ?>
                </p>
            <?php endif; ?>

            <form action="AdminDashboard.php" method="POST">

                <label for="announcement-title">
                    Title
                </label>

                <input
                    id="announcement-title"
                    name="title"
                    type="text"
                    maxlength="80"
                    required
                >

                <label for="announcement-category">
                    Category
                </label>

                <select
                    id="announcement-category"
                    name="category"
                    required
                >
                    <option value="General">General</option>
                    <option value="Event">Event</option>
                    <option value="Important">Important</option>
                </select>

                <label for="announcement-message">
                    Message
                </label>

                <textarea
                    id="announcement-message"
                    name="message"
                    rows="6"
                    maxlength="500"
                    required
                ></textarea>

                <button type="submit">
                    Publish announcement
                </button>

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

                            <time>
                                <?php
                                echo date(
                                    'F j, Y',
                                    strtotime($announcement['created_at'])
                                );
                                ?>
                            </time>

                        </div>

                        <h2>
                            <?php echo e($announcement['title']); ?>
                        </h2>

                        <p>
                            <?php echo nl2br(e($announcement['message'])); ?>
                        </p>

                    </article>

                <?php endforeach; ?>

                <?php if (!$announcements): ?>

                    <p class="header-copy">
                        No announcements yet.
                    </p>

                <?php endif; ?>

            </section>

        </section>

    </div>

</main>

</body>
</html>