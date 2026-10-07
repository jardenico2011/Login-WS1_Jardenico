<?php
session_start();

/*
|--------------------------------------------------------------------------
| ADMIN EMAIL
|--------------------------------------------------------------------------
*/
$adminEmails = [
    'jadejardenico@gmail.com'
];


/*
|--------------------------------------------------------------------------
| DATABASE CONNECTION
|--------------------------------------------------------------------------
*/
$databaseHost = '127.0.0.1';
$databaseName = 'announcement_page';
$databaseUser = 'root';
$databasePassword = '';

$database = new PDO(
    "mysql:host={$databaseHost};dbname={$databaseName};charset=utf8mb4",
    $databaseUser,
    $databasePassword
);

$database->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);


/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/
function isLoggedIn()
{
    return isset($_SESSION['user']);
}


/*
|--------------------------------------------------------------------------
| ADMIN CHECK
|--------------------------------------------------------------------------
*/
function isAdmin()
{
    return isLoggedIn()
        && $_SESSION['user']['role'] === 'admin';
}


/*
|--------------------------------------------------------------------------
| TEACHER CHECK
|--------------------------------------------------------------------------
*/
function isTeacher()
{
    return isLoggedIn()
        && $_SESSION['user']['role'] === 'teacher';
}


/*
|--------------------------------------------------------------------------
| STUDENT CHECK
|--------------------------------------------------------------------------
*/
function isStudent()
{
    return isLoggedIn()
        && in_array(
            $_SESSION['user']['role'],
            ['student', 'member'],
            true
        );
}


/*
|--------------------------------------------------------------------------
| DASHBOARD BASED ON ROLE
|--------------------------------------------------------------------------
*/
function dashboardForRole($role)
{
    if ($role === 'admin') {
        return 'AdminDashboard.php';
    }

    if ($role === 'teacher') {
        return 'TeacherDashboard.php';
    }

    if ($role === 'student') {
        return 'StudentDashboard.php';
    }

    return 'Userdashboard.php';
}


/*
|--------------------------------------------------------------------------
| REQUIRE LOGIN
|--------------------------------------------------------------------------
*/
function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| REQUIRE ADMIN
|--------------------------------------------------------------------------
*/
function requireAdmin()
{
    if (!isAdmin()) {
        header('Location: Userdashboard.php');
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| REQUIRE TEACHER
|--------------------------------------------------------------------------
*/
function requireTeacher()
{
    if (!isTeacher()) {
        header(
            'Location: ' .
            dashboardForRole($_SESSION['user']['role'])
        );
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| REQUIRE STUDENT
|--------------------------------------------------------------------------
*/
function requireStudent()
{
    if (!isStudent()) {
        header(
            'Location: ' .
            dashboardForRole($_SESSION['user']['role'])
        );
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| SAFE HTML OUTPUT
|--------------------------------------------------------------------------
*/
function e($value)
{
    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>