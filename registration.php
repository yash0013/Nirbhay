<?php
session_start();
include_once 'db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

// Function to send verification email
function sendVerificationEmail($email, $v_code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testmailysquare@gmail.com'; // Replace with your email
        $mail->Password = 'tkwiavimjmxtydbs'; // Replace with your email app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Email settings
        $mail->setFrom('testmailysquare@gmail.com', 'Nirbhay');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verify your email address for Nirbhay';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333; padding: 20px; max-width: 600px; margin: auto; border: 1px solid #ddd; border-radius: 10px;'>
            <h2 style='color: #0056b3;'>Welcome to Nirbhay!</h2>
            <p>Thank you for registering with us! To complete your registration, please verify your email by clicking the button below:</p>
            <p style='text-align: center;'>
                <a href='http://localhost/nirbhay/verify.php?email=$email&v_code=$v_code'
                   style='background-color: #0056b3; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block; font-size: 16px;'>Verify Email</a>
            </p>
            <p>If the button doesn't work, please copy and paste the following link into your browser:</p>
            <p><a href='http://localhost/nirbhay/verify.php?email=$email&v_code=$v_code'>Click to Verify</a></p>
            <p>Thank you,<br>The Nirbhay Team</p>
            <hr style='border: none; border-top: 1px solid #eee;'/>
            <p style='font-size: 12px; color: #888;'>If you didn't register with Nirbhay, please ignore this email.</p>
        </div>";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password === $confirm_password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Generate verification code
        $v_code = bin2hex(random_bytes(16));

        // Insert user data into the database with verification code
        $query = "INSERT INTO users (username, email, phone, password, verification_code, is_verified) VALUES ('$username', '$email', '$phone', '$hashed_password', '$v_code', '0')";
        
        if (mysqli_query($conn, $query) && sendVerificationEmail($email, $v_code)) {
            $_SESSION['message'] = "Registration successful! Please verify your email before logging in.";
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image" href="assets/logo.png">
    <title>Registration</title>
    <style>
        body {
            background-image: url('img/cover.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Raleway', sans-serif;
        }

        .container3 {
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            background: rgb(255 255 255 / 48%);
            backdrop-filter: blur(5px);
        }

        .container3 h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background-color: #000000ab;
            color: white;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            width: 100%;
            background-color: #0056b3;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #004a9e;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        a {
            color: #0056b3;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container3">
        <h2>Registration - Nirbhay</h2>
        <?php if (isset($error_message)) echo '<p class="error">' . $error_message . '</p>'; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password (6+ chars, 1 uppercase, 1 digit, 1 special)" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{6,}" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p><a href="login.php">Already have an account? Login here</a></p>
    </div>
</body>
</html>
