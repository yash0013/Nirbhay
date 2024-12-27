<?php
session_start();
include_once 'db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the Composer autoloader if using Composer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
// Function to send OTP via email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'testmailysquare@gmail.com';  // Your email
        $mail->Password   = 'tkwiavimjmxtydbs';           // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('testmailysquare@gmail.com', 'Nirbhay Project');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Nirbhay Login';
        $mail->Body    = "<p>Your OTP is: <strong>$otp</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                // Check if OTP is enabled for the user
                if ($user['otp_enabled'] == 1) {
                    // Generate OTP
                    $otp = rand(100000, 999999);
                    $otp_expire = date("Y-m-d H:i:s", strtotime("+10 minutes"));

                    // Store OTP in the database
                    $update_query = "UPDATE users SET otp='$otp', otp_expire='$otp_expire' WHERE id=" . $user['id'];
                    if (mysqli_query($conn, $update_query)) {
                        // Send OTP via email
                        if (sendOTP($email, $otp)) {
                            $_SESSION['email'] = $email;
                            $_SESSION['user_id'] = $user['id'];
                            // Redirect to OTP verification page
                            header("Location: otp_verify.php");
                            exit();
                        } else {
                            $error_message = "Failed to send OTP. Try again.";
                        }
                    } else {
                        $error_message = "Error storing OTP. Try again.";
                    }
                } else {
                    $_SESSION['email'] = $email;
                    $_SESSION['user_id'] = $user['id'];
                    // No OTP required, proceed to dashboard
                    header("Location: index.php");
                    exit();
                }
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "User does not exist.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image" href="assets/logo.png">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('img/cover.jpg') no-repeat center center/cover;
            margin: 0;
        }
        .container3 {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            background: rgb(255 255 255 / 48%);
            backdrop-filter: blur(5px);
        }
        .container3 h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background-color: #000000ab;
            color: white;
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
        <h2>Login - Nirbhay</h2>
        <?php if (isset($error_message)) echo '<p class="error">' . $error_message . '</p>'; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p><a href="registration.php">Don't have an account? Register here</a></p>
    </div>
</body>
</html>
