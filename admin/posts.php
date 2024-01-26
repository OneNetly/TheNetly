<?php
require_once '../config.php';

// Pagination
$limit = 10; // Number of posts per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch posts from database
$stmt = $pdo->prepare("SELECT * FROM posts LIMIT $start, $limit");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total number of posts
$total_posts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$total_pages = ceil($total_posts / $limit);

// HTML for displaying posts
echo "<h1>Posts</h1>";
foreach ($posts as $post) {
    echo "<div>";
    echo "<h2>{$post['title']}</h2>";
    echo "<p>{$post['content']}</p>";
    echo "<img src='{$post['featured_image']}' alt='Featured Image'>";
    echo "<p><a href='edit_post.php?id={$post['id']}'>Edit</a> | <a href='delete_post.php?id={$post['id']}'>Delete</a></p>";
    echo "</div>";
}

// Pagination links
echo "<div>";
echo "<p>Page: ";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='posts.php?page=$i'>$i</a> ";
}
echo "</p>";
echo "</div>";
?>
