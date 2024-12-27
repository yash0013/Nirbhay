<?php
session_start();
include_once 'db_connect.php';

// Check if email and verification code are provided in the URL
if (isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = $_GET['email'];
    $v_code = $_GET['v_code'];

    // Check if the provided email and verification code match in the database
    $query = "SELECT * FROM users WHERE email = '$email' AND verification_code = '$v_code' AND is_verified = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Verification successful, update the user's status to verified
        $update_query = "UPDATE users SET is_verified = 1 WHERE email = '$email'";
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['message'] = "Your email has been successfully verified! You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error: Unable to verify your email. Please try again later.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid or expired verification link.";
    }
} else {
    $_SESSION['error_message'] = "Invalid access.";
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Raleway', sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 400px;
        }
        .container h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 20px;
            font-size: 16px;
            color: #333;
        }
        a {
            color: #0056b3;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border-radius: 5px;
            display: inline-block;
        }
        a:hover {
            background-color: #004a9e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Email Verification</h2>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='message'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['message'])) {
            echo "<p class='message'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <p><a href="login.php">Go to Login</a></p>
    </div>
</body>
</html>
