<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Browsing URL Checker</title>
    <style>
        body {
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
            margin-top:150px;
            margin-bottom:100px;
            margin-left:460px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
<?php include_once("header.php"); ?> 

<div class="content">
    <h1 style="color: #333; font-size: 24px;">Safe Browsing URL Checker</h1>

    <form method="POST" style="margin-bottom: 20px;">
        <label for="url" style="font-size: 16px;">Enter URL:</label>
        <input type="text" name="url" id="url" placeholder="https://example.com" required
               style="padding: 8px; font-size: 16px; width: 100%; margin-bottom: 10px;"><br>
        <button type="submit" name="check_url">Check URL</button>
    </form>

    <?php
    if (isset($_POST['check_url'])) {
        $urlToCheck = $_POST['url'];
        $labelFound = '';

        // Normalize the URL to ignore protocol, case, and trailing slashes
        $normalizedUrlToCheck = strtolower(trim(parse_url($urlToCheck, PHP_URL_HOST) . parse_url($urlToCheck, PHP_URL_PATH)));
        $normalizedUrlToCheck = rtrim($normalizedUrlToCheck, '/');

        // Path to dataset
        $csvFile = __DIR__ . '/ds/malicious_phish.csv';

        // Check if the file exists and is readable
        if (file_exists($csvFile) && is_readable($csvFile)) {
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Read through the dataset
                fgetcsv($handle); // Skip the header row (if exists)

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Ensure the row has at least two columns (URL and label)
                    if (isset($data[0]) && isset($data[1])) {
                        // Normalize dataset URL for comparison
                        $datasetUrl = strtolower(trim(parse_url($data[0], PHP_URL_HOST) . parse_url($data[0], PHP_URL_PATH)));
                        $datasetUrl = rtrim($datasetUrl, '/');
                        $label = strtolower($data[1]); // phishing/benign/defacement

                        // Compare input URL with dataset URL
                        if ($normalizedUrlToCheck === $datasetUrl) {
                            $labelFound = $label;
                            break; // Found the URL, no need to check further
                        }
                    }
                }

                fclose($handle);

                // Display the result based on the label found
                if ($labelFound === 'phishing') {
                    echo "<div style='color: red;'>The URL is flagged as phishing!</div>";
                } elseif ($labelFound === 'defacement') {
                    echo "<div style='color: orange;'>The URL is flagged as defacement!</div>";
                } elseif ($labelFound === 'benign') {
                    echo "<div style='color: green;'>The URL is safe (benign)!</div>";
                } else {
                    echo "<div style='color: blue;'>The URL is not found in the dataset.</div>";
                }
            } else {
                echo "<div style='color: red;'>Error: Could not read the dataset file.</div>";
            }
        } else {
            echo "<div style='color: red;'>Error: Dataset not found or not readable.</div>";
        }
    }
    ?>
</div>
<?php include_once("footer.php"); ?> 

</body>
</html>
