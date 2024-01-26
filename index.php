<?php
include 'header.php';
require_once('config.php');

// Step 1: Retrieve Categories
$sql = "SELECT id, name FROM categories";
$stmt = $pdo->query($sql);

// Step 2: Display Categories on the Frontend
if ($stmt->rowCount() > 0) {
    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li><a href='category.php?id=" . $row["id"] . "'>" . $row["name"] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "No categories found";
}

// Step 3: Fetch Posts for Selected Category (category.php)
// This code will be in category.php
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $sqlPosts = "SELECT p.id, p.title, p.content, p.created_at FROM posts p
                 INNER JOIN post_categories pc ON p.id = pc.post_id
                 WHERE pc.category_id = ?";
    $stmtPosts = $pdo->prepare($sqlPosts);
    $stmtPosts->execute([$categoryId]);

    if ($stmtPosts->rowCount() > 0) {
        while ($row = $stmtPosts->fetch(PDO::FETCH_ASSOC)) {
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<p>" . $row["content"] . "</p>";
            echo "<p>Posted on: " . $row["created_at"] . "</p>";
        }
    } else {
        echo "No posts found for this category";
    }
}

// Number of posts per page
$posts_per_page = 10;

// Get total number of posts
$stmtTotalPosts = $pdo->query("SELECT COUNT(*) AS total_posts FROM posts");
$total_posts = $stmtTotalPosts->fetch(PDO::FETCH_ASSOC)['total_posts'];

// Calculate total number of pages
$total_pages = ceil($total_posts / $posts_per_page);

// Get current page number
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($current_page - 1) * $posts_per_page;

// Retrieve posts for the current page
$sql = "SELECT * FROM posts LIMIT $offset, $posts_per_page";
$stmt = $pdo->query($sql);

// Display posts
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p>" . $row['content'] . "</p>";
    }
} else {
    echo "No posts found.";
}

// Display pagination links
echo "<div>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='index.php?page=$i'>$i</a> ";
}
echo "</div>";
?>