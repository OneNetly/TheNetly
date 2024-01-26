<?php
// Include database configuration file
require_once "config.php";

// Check if category ID is provided in the URL
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = $_GET['id'];

    // Retrieve category name from the database
    $sql_category = "SELECT name FROM categories WHERE id = :category_id";
    $stmt_category = $pdo->prepare($sql_category);
    $stmt_category->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt_category->execute();

    $row_category = $stmt_category->fetch(PDO::FETCH_ASSOC);

    if ($row_category) {
        $category_name = $row_category['name'];

        // Retrieve posts belonging to the specified category
        $sql_posts = "SELECT * FROM posts 
                      INNER JOIN post_categories ON posts.id = post_categories.post_id
                      WHERE post_categories.category_id = :category_id";
        $stmt_posts = $pdo->prepare($sql_posts);
        $stmt_posts->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt_posts->execute();

        // Display category name
        echo "<h2>Posts in Category: $category_name</h2>";

        // Display posts
        $result_posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);
        if ($result_posts) {
            foreach ($result_posts as $row_posts) {
                echo "<h3>" . $row_posts['title'] . "</h3>";
                echo "<p>" . $row_posts['content'] . "</p>";
            }
        } else {
            echo "No posts found in this category.";
        }
    } else {
        echo "Category not found.";
    }
} else {
    echo "Invalid category ID.";
}

// Close database connection (not necessary for PDO)
// $pdo->close(); // Commented out because PDO doesn't have a close() method
?>
