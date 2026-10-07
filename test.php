<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST is working!";
} else {
    echo '<form method="post">';
    echo '<button type="submit">TEST POST</button>';
    echo '</form>';
}
?>