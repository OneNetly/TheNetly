<?php
include 'header.php';
require_once('config.php');

// Check if post ID is provided in the URL
if(isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Retrieve the post details from the database based on the post ID
    $sql = "SELECT title, content, featured_image FROM posts WHERE id = :post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display post details
    if($post) {
        echo "<div class='mb-8'>";
        echo "<h2 class='text-xl font-bold mb-2'>" . $post['title'] . "</h2>";
        echo "<img src='" . $post['featured_image'] . "' alt='" . $post['title'] . "' class='w-full h-auto mb-4 rounded'>";
        echo "<p class='text-gray-700'>" . $post['content'] . "</p>";
        echo "</div>";
    } else {
        echo "<div class='text-gray-700'>Post not found.</div>";
    }
} else {
    echo "<div class='text-gray-700'>Invalid request.</div>";
}

?>
