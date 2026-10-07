<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $requestedRole = $_POST['role'] ?? '';

    if (!$firstName || !$lastName || !$email || !$phone || strlen($password) < 4) {
        $error = 'Please complete all fields. Password must have at least 4 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!in_array($requestedRole, ['student', 'teacher', 'admin'], true)) {
        $error = 'Please select a valid account type.';
    } else {

        $role = $requestedRole;

        try {
            $statement = $database->prepare(
                'INSERT INTO users
                (first_name, last_name, email, phone, password, role)
                VALUES (?, ?, ?, ?, ?, ?)'
            );

            $statement->execute([
                $firstName,
                $lastName,
                $email,
                $phone,
                password_hash($password, PASSWORD_DEFAULT),
                $role
            ]);

            // Clear any existing login session
            session_unset();
            session_destroy();

            // Always return to Login after registration
            header(
                'Location: index.php?error=' .
                urlencode('Account created. You can now log in.')
            );
            exit;

        } catch (PDOException $exception) {
            $error = 'Database error: ' . $exception->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register | ANNOUNCEMENT PAGE</title>
</head>

<body>

<main class="login-card">

    <p class="brand-name">ANNOUNCEMENT PAGE</p>

    <h1>Create account</h1>

    <p class="subtitle">
        Fill in your details to get started
    </p>

    <?php if ($error): ?>
        <p class="error-message">
            <?php echo e($error); ?>
        </p>
    <?php endif; ?>

    <form action="register.php" method="post" autocomplete="off">

        <label for="first-name">First name</label>
        <input
            id="first-name"
            name="first_name"
            type="text"
            required
        >

        <label for="last-name">Last name</label>
        <input
            id="last-name"
            name="last_name"
            type="text"
            required
        >

        <label for="email">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            autocomplete="email"
            required
        >

        <label for="phone">Phone number</label>
        <input
            id="phone"
            name="phone"
            type="tel"
            required
        >

        <label for="role">Account Type</label>
        <select
            id="role"
            name="role"
            required
        >
            <option value="">Select Account Type</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="admin">Admin</option>
        </select>

        <label for="password">Password</label>
        <input
            id="password"
            name="password"
            type="password"
            minlength="4"
            autocomplete="new-password"
            required
        >

        <button type="submit">
            Create Account
        </button>

        <a class="secondary-button" href="index.php">
            Back to Login
        </a>

    </form>

</main>

</body>
</html>