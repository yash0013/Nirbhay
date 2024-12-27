<?php
include 'db_connect.php';

session_start();
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

$post_id = intval($_POST['post_id']);

$query = "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Unlike
    $query = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
} else {
    // Like
    $query = "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)";
}

if (mysqli_query($conn, $query)) {
    header('Location: forum.php');
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
