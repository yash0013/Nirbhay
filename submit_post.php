<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        echo "Title or content is missing.";
    } else {
        $insert_post = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_post);
        $stmt->bind_param("iss", $user_id, $title, $content);
        if ($stmt->execute()) {
            header('Location: forum.php');
        } else {
            echo "Error submitting post: " . $stmt->error;
        }
    }
}
?>
