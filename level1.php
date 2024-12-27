<?php
// Include database connection file
include('db_connect.php');

// Start session to track user
session_start();

// Fetch user email from session
$user_email = $_SESSION['email'] ?? null;

// Check if user is logged in
if (!$user_email) {
    header("Location: login.php");
    exit();
}

// Fetch user progress from the progress table
$query = "SELECT * FROM progress WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user progress data is found
if ($result->num_rows > 0) {
    $user_progress = $result->fetch_assoc();
} else {
    // Initialize user progress if not found
    $user_progress = ['completed' => 0];
}

// Initialize level progress
$level_completed = isset($user_progress['completed']) ? $user_progress['completed'] : 0;

// Predefined question and correct answer for level 1
$question = "What color is the sky?";
$correct_answer = "red";

// If the form is submitted with the answer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    $answer = $_POST['answer'];

    if ($answer === $correct_answer) {
        // Update the user's progress in the database
        $query = "INSERT INTO progress (email, levelid, completed) VALUES (?, 1, 1)
                  ON DUPLICATE KEY UPDATE completed = 1, levelid = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();

        // Update level progress
        $level_completed = 1;
    } else {
        $error_message = "Incorrect answer. The correct answer is: " . $correct_answer;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 1</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS -->
</head>
<body>
    <h1>Welcome to Level 1</h1>

    <!-- Display progress bar -->
    <div class="progress-container">
        <div class="progress-bar" style="width: <?php echo ($level_completed == 1) ? '100%' : '0%'; ?>;">
            <?php echo ($level_completed == 1) ? 'Level 1 Completed' : 'Level 1 In Progress'; ?>
        </div>
    </div>

    <!-- Predefined question and answer form -->
    <div class="question-section">
        <form method="POST" action="">
            <p><?php echo $question; ?></p>
            <input type="text" name="answer" placeholder="Type your answer here" required>
            <button type="submit">Submit Answer</button>
        </form>
        <?php if (isset($error_message)): ?>
            <p style="color:red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

    <!-- Button to proceed to the next level -->
    <?php if ($level_completed == 1): ?>
        <div class="next-level-button">
            <a href="level2.php"><button>Proceed to Level 2</button></a>
        </div>
    <?php endif; ?>

</body>
</html>
