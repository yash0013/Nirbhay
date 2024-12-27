<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_auth.php");
    exit();
}

include('db_connect.php');

// Handle user removal
if (isset($_GET['remove_id'])) {
    $remove_id = intval($_GET['remove_id']);
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $remove_id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Refresh to reflect changes
        exit();
    } else {
        echo "Error removing user: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve user details
$sql_users = "SELECT id, username, email, phone FROM users";
$result_users = $conn->query($sql_users);

// Retrieve user progress
$sql_progress = "SELECT users.id, users.username, users.email, 
                 COUNT(DISTINCT levelid) as total_levels,
                 SUM(completed) as total_completed
                 FROM users
                 LEFT JOIN progress ON users.email = progress.email
                 GROUP BY users.id";
$result_progress = $conn->query($sql_progress);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h1, h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        .user-table, .progress-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .user-table th, .user-table td,
        .progress-table th, .progress-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .user-table th, .progress-table th {
            background-color: #2c3e50;
            color: #fff;
        }

        .user-table tr:nth-child(even), .progress-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tr:hover, .progress-table tr:hover {
            background-color: #f1c40f;
            color: #fff;
        }

        .remove-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .remove-button:hover {
            background-color: #c0392b;
        }

        .progress-bar {
            position: relative;
            height: 20px;
            background-color: #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar span {
            display: block;
            height: 100%;
            background-color: #2ecc71;
            text-align: center;
            color: #fff;
            line-height: 20px;
            font-weight: bold;
            width: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="admin_logout.php" class="logout-button">Logout</a>

        <h2>User Details</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>
                            <a href="?remove_id=<?php echo htmlspecialchars($row['id']); ?>" class="remove-button" onclick="return confirm('Are you sure you want to remove this user?');">Remove</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>User Progress</h2>
        <table class="progress-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_progress->fetch_assoc()): ?>
                    <?php
                        // Calculate progress percentage
                        $total_levels = $row['total_levels'];
                        $total_completed = $row['total_completed'];
                        $progress_percentage = ($total_levels > 0) ? ($total_completed / $total_levels) * 100 : 0;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <div class="progress-bar">
                                <span style="width: <?php echo htmlspecialchars($progress_percentage); ?>%">
                                    <?php echo htmlspecialchars(number_format($progress_percentage, 2)); ?>%
                                </span>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
