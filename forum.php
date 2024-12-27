<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle new reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])) {
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    if (empty($post_id) || empty($content)) {
        echo "Post ID or content is missing.";
    } else {
        $insert_reply = "INSERT INTO replies (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_reply);
        $stmt->bind_param("iis", $post_id, $user_id, $content);
        if ($stmt->execute()) {
            echo "Reply added successfully.";
        } else {
            echo "Error adding reply: " . $stmt->error;
        }
    }
}

// Handle like/unlike
if (isset($_GET['like'])) {
    $post_id = $_GET['like'];
    $user_id = $_SESSION['user_id'];

    $check_like = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_like);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Unlike
        $delete_like = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $conn->prepare($delete_like);
        $stmt->bind_param("ii", $post_id, $user_id);
        if ($stmt->execute()) {
            echo "Post unliked.";
        } else {
            echo "Error unliking post: " . $stmt->error;
        }
    } else {
        // Like
        $insert_like = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_like);
        $stmt->bind_param("ii", $post_id, $user_id);
        if ($stmt->execute()) {
            echo "Post liked.";
        } else {
            echo "Error liking post: " . $stmt->error;
        }
    }
}

// Fetch posts
$posts_query = "SELECT p.id, p.title, p.content, p.created_at, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
$posts_result = $conn->query($posts_query);

if (!$posts_result) {
    die("Error fetching posts: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
</head>
<body style="font-family: 'Arial', sans-serif; background-color: #e6ecf0; margin: 0; padding: 0;">
    <?php include_once("header.php"); ?>

    <div style="max-width: 600px; margin: 20px auto; padding: 20px; background: #ffffff; border-radius: 16px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); position: relative;">

        <div style="background: #000000; color: #fff; padding: 40px 20px; text-align:  center; border-radius: 5px; margin-bottom: 20px; margin-top: 65px;">
            <h1 style="font-size: 36px; margin: 0; color: #fff; padding-bottom: 10px;">Cybersecurity Discussion Forum</h1>
            <p style="font-size: 18px; color: #bfbfbf; margin: 10px 0;">Welcome to our forum! Engage with experts and enthusiasts to learn and share knowledge about cybersecurity.</p>
            <a href="#" style="color: #fff; text-decoration: none; background: #0056b3; padding: 10px 20px; border-radius: 5px; font-weight: bold;">Explore Resources</a>
            <a href="#" style="color: #fff; text-decoration: none; background: #0056b3; padding: 10px 20px; border-radius: 5px; font-weight: bold;">Join Discussions</a>
            <a href="#" style="color: #fff; text-decoration: none; background: #0056b3; padding: 10px 20px; border-radius: 5px; font-weight: bold;">Get Tips</a>
        </div>

        <button id="toggleForm" style="position: fixed; bottom: 20px; right: 220px; background-color: #1da1f2; color: #ffffff; border: none; border-radius: 50%; width: 60px; height: 60px; font-size: 24px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); cursor: pointer; transition: background-color 0.3s, box-shadow 0.3s;">+</button>

        <div id="postForm" style="display: none; position: fixed; bottom: 100px; right: 20px; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); padding: 20px; width: 300px; z-index: 1000;">
            <h2 style="margin-top: 0;">Submit a Post</h2>
            <form action="submit_post.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ccd6dd; border-radius: 8px; box-sizing: border-box; margin-bottom: 10px;">
                <label for="content">Content:</label>
                <textarea id="content" name="content" required style="width: 100%; padding: 10px; border: 1px solid #ccd6dd; border-radius: 8px; box-sizing: border-box; margin-bottom: 10px;"></textarea>
                <input type="submit" value="Submit" style="background-color: #1da1f2; color: #ffffff; border: none; padding: 10px 20px; border-radius: 24px; cursor: pointer; font-size: 14px; font-weight: bold; transition: background-color 0.3s;">
            </form>
        </div>

        <?php while ($post = $posts_result->fetch_assoc()): ?>
            <div style="border: none; border-radius: 12px; padding: 15px; margin-bottom: 20px; background: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
                <h2 style="margin: 0; font-size: 20px; color: #1da1f2;"><?php echo htmlspecialchars($post['title']); ?></h2>
                <p style="margin: 10px 0; color: #14171a; line-height: 1.5;"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <p style="font-size: 14px; color: #657786;">Posted by <?php echo htmlspecialchars($post['username']); ?> on <?php echo $post['created_at']; ?></p>

                <?php
                $user_id = $_SESSION['user_id'];
                $check_like = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
                $stmt = $conn->prepare($check_like);
                $stmt->bind_param("ii", $post['id'], $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>
                <a href="?like=<?php echo $post['id']; ?>" style="color: #1da1f2; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; margin-right: 10px; border-radius: 16px; padding: 5px 10px; background: <?php echo $result->num_rows > 0 ? '#e8f5fe' : 'transparent'; ?>;" onmouseover="this.style.backgroundColor='#e8f5fe';" onmouseout="this.style.backgroundColor='';">
                    <?php echo $result->num_rows > 0 ? 'Unlike' : 'Like'; ?>
                </a>

                <h3>Replies</h3>
                <?php
                $replies_query = "SELECT r.content, r.created_at, u.username FROM replies r JOIN users u ON r.user_id = u.id WHERE r.post_id = ? ORDER BY r.created_at ASC";
                $stmt = $conn->prepare($replies_query);
                $stmt->bind_param("i", $post['id']);
                $stmt->execute();
                $replies_result = $stmt->get_result();
                ?>
                <?php while ($reply = $replies_result->fetch_assoc()): ?>
                    <div style="border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px;">
                        <p style="margin: 0; color: #14171a;"><?php echo htmlspecialchars($reply['content']); ?></p>
                        <p style="font-size: 12px; color: #657786;">Replied by <?php echo htmlspecialchars($reply['username']); ?> on <?php echo $reply['created_at']; ?></p>
                    </div>
                <?php endwhile; ?>

                <form method="post" action="" style="margin-top: 10px;">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <textarea name="content" required style="width: 100%; padding: 10px; border: 1px solid #ccd6dd; border-radius: 8px; box-sizing: border-box; margin-bottom: 10px;" placeholder="Add a reply..."></textarea>
                    <input type="submit" name="reply" value="Reply" style="background-color: #1da1f2; color: #ffffff; border: none; padding: 10px 20px; border-radius: 24px; cursor: pointer; font-size: 14px; font-weight: bold; transition: background-color 0.3s;">
                </form>
            </div>
        <?php endwhile; ?>

    </div>

    <script>
        document.getElementById('toggleForm').addEventListener('click', function() {
            var form = document.getElementById('postForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>

</body>
</html>
