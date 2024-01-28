<?php
include 'header.php';
require_once('config.php');

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
$sql = "SELECT id, title, featured_image FROM posts ORDER BY modified_date DESC LIMIT $offset, $posts_per_page";

$stmt = $pdo->query($sql);

// HTML structure for displaying posts
?>
<div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
        <div class="grid gap-4 sm:grid-cols-2 md:gap-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-8">

            <?php
            // Display posts
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<a href='post.php?id=" . $row['id'] . "' class='group relative flex h-48 flex-col overflow-hidden rounded-lg bg-gray-100 shadow-lg md:h-64 xl:h-96'>";
                    echo "<img src='" . $row['featured_image'] . "' loading='lazy' alt='" . $row['title'] . "' class='absolute inset-0 h-full w-full object-cover object-center transition duration-200 group-hover:scale-110' />";
                    echo "<div class='pointer-events-none absolute inset-0 bg-gradient-to-t from-gray-800 to-transparent md:via-transparent'></div>";
                    echo "<div class='relative mt-auto p-4'>";
                    echo "<h2 class='mb-2 text-xl font-semibold text-white transition duration-100'>" . $row['title'] . "</h2>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "<div class='text-gray-700'>No posts found.</div>";
            }
            ?>

        </div>
    </div>
</div>

<?php
// Display pagination links
echo "<div class='mt-8'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='index.php?page=$i' class='mr-2 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600'>$i</a>";
}
echo "</div>";
?>
