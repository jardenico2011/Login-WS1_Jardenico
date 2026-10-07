```php
<?php
require 'config.php';

if (isLoggedIn()) {
    header('Location: ' . dashboardForRole($_SESSION['user']['role']));
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
    <title>Login | ANNOUNCEMENT PAGE</title>
</head>
<body>
    <main class="login-card">
        <p class="brand-name">ANNOUNCEMENT PAGE</p>
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

        <div class="demo-accounts">
            <h3>Demo Accounts</h3>

            <div class="demo-account">
                <strong>Student</strong>
                <p>Username: jardenicojade@gmail.com</p>
                <p>Password: jade12345</p>
            </div>

            <div class="demo-account">
                <strong>Teacher</strong>
                <p>Username: jadejardenico@gmail.com</p>
                <p>Password: jade123</p>
            </div>

            <div class="demo-account">
                <strong>Admin</strong>
                <p>Username: Kimtoyjardenico@gmail.com</p>
                <p>Password: kimtoy123</p>
            </div>
        </div>

        <p class="register-link">
            Don't have an account? <a href="register.php">Register</a>
        </p>
    </main>
</body>
</html>
```
