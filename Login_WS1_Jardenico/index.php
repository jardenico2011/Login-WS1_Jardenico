<?php
require 'config.php';

if (isLoggedIn()) {
    header('Location: Userdashboard.php');
    exit;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login | Peace Freedom</title>
</head>
<body>
    <main class="login-card">
        <p class="brand-name">ANNOUNCEMENTS PAGE</p>
        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to your account</p>

        <?php if ($error): ?>
            <p class="error-message"><?php echo e($error); ?></p>
        <?php endif; ?>

        <form action="login.php" method="post" autocomplete="off">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="" required>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" value="" required>

            <button type="submit">Login</button>
        </form>

        <p class="register-link">
            Don't have an account? <a href="register.php">Register</a>
        </p>
    </main>
</body>
</html>
