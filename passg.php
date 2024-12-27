<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Password Generator</title>
    <script>
        // Function to copy password to clipboard
        function copyToClipboard() {
            var passwordText = document.getElementById("generatedPassword");
            navigator.clipboard.writeText(passwordText.textContent).then(() => {
                alert("Password copied to clipboard!");
            });
        }
    </script>
</head>


<body style="justify-content: center; align-items: center; height: 100vh; background-color: #f5f5f5; font-family: Arial, sans-serif;">

<?php include_once("header.php"); ?> 

<div style="background-color: white; padding: 15px; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0,0,0,0.1); width: 400px; text-align: center; margin-top: 110px; margin-left: 400px;">
    <h1 style="color: #333; font-size: 24px; ">Password Generator</h1>
    
    <form method="POST" style="margin-bottom: 20px;">
        <label for="length" style="font-size: 16px;">Password Length:</label>
        <input type="number" name="length" id="length" value="12" min="6" max="20" style="padding: 8px; font-size: 16px; width: 60px; margin-bottom: 10px;"><br>

        <div style="margin: 10px 0;">
            <input type="checkbox" name="special_chars" id="special_chars" checked>
            <label for="special_chars" style="font-size: 14px;">Include Special Characters</label>
        </div>

        <div style="margin: 10px 0;">
            <input type="checkbox" name="only_letters" id="only_letters">
            <label for="only_letters" style="font-size: 14px;">Only Letters</label>
        </div>

        <div style="margin: 10px 0;">
            <input type="checkbox" name="only_numbers" id="only_numbers">
            <label for="only_numbers" style="font-size: 14px;">Only Numbers</label>
        </div>

        <button type="submit" name="generate" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; font-size: 16px; border-radius: 5px;">Generate Password</button>
    </form>

    <?php
    // Function to generate a random password
    function generatePassword($length = 12, $includeSpecial = true, $onlyLetters = false, $onlyNumbers = false) {
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()';
        $characters = '';

        if ($onlyLetters) {
            $characters .= $letters;
        } elseif ($onlyNumbers) {
            $characters .= $numbers;
        } else {
            $characters .= $letters . $numbers;
            if ($includeSpecial) {
                $characters .= $specialChars;
            }
        }

        $password = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $charactersLength - 1)];
        }

        return $password;
    }

    if (isset($_POST['generate'])) {
        $passwordLength = isset($_POST['length']) ? (int)$_POST['length'] : 12;
        $includeSpecial = isset($_POST['special_chars']);
        $onlyLetters = isset($_POST['only_letters']);
        $onlyNumbers = isset($_POST['only_numbers']);
        $newPassword = generatePassword($passwordLength, $includeSpecial, $onlyLetters, $onlyNumbers);
    }
    ?>

    <?php if (isset($newPassword)): ?>
        <div style="margin-top: 20px;">
            <strong style="font-size: 18px;">Your Password:</strong>
            <div id="generatedPassword" style="font-size: 20px; margin-top: 10px; padding: 10px; background-color: #f0f0f0; border-radius: 5px; word-break: break-all; color: #FF5722;">
                <?php echo htmlspecialchars($newPassword); ?>
            </div>
            <button onclick="copyToClipboard()" style="margin-top: 15px; padding: 10px 20px; background-color: #2196F3; color: white; border: none; cursor: pointer; font-size: 16px; border-radius: 5px;">Copy to Clipboard</button>
        </div>
    <?php endif; ?>
</div>
<br>
<?php include_once("footer.php"); ?> 


</body>
</html>
