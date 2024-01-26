<?php
require_once '../config.php';

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid post ID.";
    exit;
}

// Retrieve post details from the database
$post_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :post_id");
$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if post exists
if (!$post) {
    echo "Post not found.";
    exit;
}

// Handle post deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Disable foreign key checks
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        
        // Delete post from the database
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :post_id");
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Post deleted successfully.";
            // Redirect to desired page after deletion
            exit;
        } else {
            echo "Error deleting post.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Re-enable foreign key checks
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Post</title>
</head>
<body>
    <h1>Delete Post</h1>
    <p>Are you sure you want to delete this post?</p>
    <p><strong>Title:</strong> <?php echo $post['title']; ?></p>
    <p><strong>Content:</strong> <?php echo $post['content']; ?></p>
    <form method="post">
        <input type="submit" value="Delete">
    </form>
</body>
</html>
