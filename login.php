<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$statement = $database->prepare('SELECT * FROM users WHERE email = ?');
$statement->execute([$email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    header('Location: index.php?error=' . urlencode('Incorrect email or password.'));
    exit;
}

$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['first_name'] . ' ' . $user['last_name'],
    'role' => $user['role']
];

header('Location: ' . dashboardForRole($user['role']));
exit;
?>
