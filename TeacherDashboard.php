<?php
require 'config.php';
requireLogin();
requireTeacher();

$error = '';

/*
|--------------------------------------------------------------------------
| PUBLISH ANNOUNCEMENT
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? 'General';
    $message = trim($_POST['message'] ?? '');

    $allowedCategories = [
        'General',
        'Event',
        'Important'
    ];

    if ($title === '' || $message === '') {

        $error = 'Please enter a title and message.';

    } elseif (!in_array($category, $allowedCategories, true)) {

        $error = 'Invalid category.';

    } else {

        try {

            $statement = $database->prepare(
                'INSERT INTO announcements
                (title, category, message, created_at)
                VALUES (?, ?, ?, NOW())'
            );

            $statement->execute([
                $title,
                $category,
                $message
            ]);

            header('Location: TeacherDashboard.php');
            exit;

        } catch (PDOException $exception) {

            $error = 'Database error: ' .
                     $exception->getMessage();
        }
    }
}


/*
|--------------------------------------------------------------------------
| JSON DATA
|--------------------------------------------------------------------------
*/
if (isset($_GET['data'])) {

    $announcements = $database
        ->query(
            'SELECT *
             FROM announcements
             ORDER BY id DESC'
        )
        ->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode([
        'name' => $_SESSION['user']['name'],
        'announcements' => $announcements
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| LOAD TEACHER DASHBOARD
|--------------------------------------------------------------------------
*/
header('Content-Type: text/html; charset=utf-8');

readfile(__DIR__ . '/TeacherDashboard.html');
?>