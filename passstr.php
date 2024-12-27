<?php
// Function to check password strength
function checkPasswordStrength($password) {
    $strength = 0;
    $length = strlen($password);

    // Check password length
    if ($length >= 8) {
        $strength += 25; // Add 25% if length is at least 8 characters
    } else {
        $strength += ($length / 8) * 25; // Partial score based on length
    }

    // Check if password contains numbers
    if (preg_match('/[0-9]/', $password)) {
        $strength += 25; // Add 25% if there are numbers
    }

    // Check if password contains both uppercase and lowercase letters
    if (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
        $strength += 25; // Add 25% for both upper and lower case letters
    }

    // Check if password contains special characters
    if (preg_match('/[\W_]/', $password)) {
        $strength += 25; // Add 25% for special characters
    }

    // Calculate strength percentage
    $strength = min(100, $strength); // Cap the strength at 100%

    // Determine the strength rating
    if ($strength >= 80) {
        $rating = "Strong";
    } elseif ($strength >= 50) {
        $rating = "Moderate";
    } else {
        $rating = "Weak";
    }

    return [
        'strength' => $strength,
        'rating' => $rating
    ];
}

// Example usage
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $result = checkPasswordStrength($password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Strength Checker</title>
</head>
<body style="background-color: #f4f4f9; font-family: 'Arial', sans-serif; justify-content: center; align-items: center; height: 100vh; margin: 0;">

<?php include_once("header.php"); ?> 

<div style="background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); text-align: center; width: 400px; margin-top: 140px;
    margin-left: 400px; margin-bottom: 40px">
    <h1 style="color: #333; font-size: 24px;">Password Strength Checker</h1>

    <form method="POST">
        <input type="password" name="password" placeholder="Enter your password" required
               style="padding: 10px; width: 80%; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; margin-bottom: 15px; transition: border 0.3s;">
        <br>
        <button type="submit"
                style="padding: 12px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; font-size: 16px; border-radius: 8px; transition: background-color 0.3s;">
            Check Strength
        </button>
    </form>

    <?php if (isset($result)): ?>
        <div style="margin-top: 20px; padding: 15px; border-radius: 8px; background-color: #f0f0f0; color: <?php echo ($result['rating'] === 'Strong') ? 'green' : (($result['rating'] === 'Moderate') ? 'orange' : 'red'); ?>;">
            <strong style="font-size: 18px;">Password Strength: <?php echo $result['strength']; ?>%</strong><br>
            <span style="font-size: 16px;"><strong><?php echo $result['rating']; ?></strong></span>

            <div style="width: 100%; height: 10px; background-color: #ddd; border-radius: 5px; margin-top: 10px; position: relative;">
                <span style="display: block; height: 100%; border-radius: 5px; width: <?php echo $result['strength']; ?>%; background-color: <?php echo ($result['strength'] >= 80) ? 'green' : (($result['strength'] >= 50) ? 'orange' : 'red'); ?>;"></span>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php include_once("footer.php"); ?> 

</body>
</html>
