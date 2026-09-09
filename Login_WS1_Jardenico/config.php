<?php
session_start();

// Add the email address of the account that should be an administrator.
$adminEmails = [
    'jadejardenico@gmail.com'
];

$databaseHost = '127.0.0.1';
$databaseName = 'announcement_management';
$databaseUser = 'root';
$databasePassword = '';

$database = new PDO(
    "mysql:host={$databaseHost};dbname={$databaseName};charset=utf8mb4",
    $databaseUser,
    $databasePassword
);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: Userdashboard.php');
        exit;
    }
}

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
