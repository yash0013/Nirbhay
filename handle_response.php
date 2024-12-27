<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$email = $_SESSION['email'];
$response = $_POST['response'];

// Handle response and update progress
// Dummy response handling
if ($response === 'response1') {
    $message = "Great choice! Let me show you more.";
} else {
    $message = "That's not quite right. Try again.";
}

// Update level progress
$sql = "UPDATE level_progress SET completed = 1 WHERE email = ? AND levelid = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$response_data = [
    'hacker_message' => $message,
    'progress' => 100 // Example value, should be calculated dynamically
];

echo json_encode($response_data);
?>
