<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include_once 'db_connect.php';

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle OTP enable/disable
if (isset($_POST['toggle_otp'])) {
    $new_otp_status = $user['otp_enabled'] == 1 ? 0 : 1;  // Toggle the OTP status
    $update_query = "UPDATE users SET otp_enabled = $new_otp_status WHERE id = $user_id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: account.php"); // Refresh the page to reflect changes
        exit();
    } else {
        $error_message = "Failed to update OTP setting. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; background-image: url('img/cover.jpg'); background-size: 100%; background-repeat: no-repeat; background-position: 38% 13%;">

    <div class="container" style="display: flex; flex-direction: column; max-width: 400px; margin: 173px auto; padding: 20px; border: 1px solid rgba(255, 255, 255, 0.25); border-radius: 20px; background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(9.9px); -webkit-backdrop-filter: blur(2.9px);">
        <h2 style="margin-top: 0; color: white;">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <div class="account-details" style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">
            <p style="margin: 10px 0; font-weight: bolder; color: white;"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p style="margin: 10px 0; font-weight: bolder; color: white;"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p style="margin: 10px 0; font-weight: bolder; color: white;"><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p style="margin: 10px 0; font-weight: bolder; color: white;"><strong>OTP Verification:</strong> <?php echo $user['otp_enabled'] == 1 ? 'Enabled' : 'Disabled'; ?></p>
        </div>
        
        <!-- OTP Enable/Disable Button -->
        <form method="post">
            <button type="submit" name="toggle_otp" style="display: inline-block; padding: 10px 20px; background-color: #007bff61; color: #fff; width: 250px; margin-top: 5px; text-decoration: none; border-radius: 15px; transition: background-color 0.3s; cursor: pointer;">
                <?php echo $user['otp_enabled'] == 1 ? 'Disable OTP' : 'Enable OTP'; ?>
            </button>
        </form>

        <div class="logout-btn-container" style="text-align: center;">
            <form method="post">
                <button type="submit" name="logout" style="display: inline-block; padding: 10px 20px; background-color: #007bff61; color: #fff; width: 250px; margin-top: 5px; text-decoration: none; border-radius: 15px; transition: background-color 0.3s; cursor: pointer;">Logout</button>
            </form>
        </div>
    </div>

</body>
</html>
