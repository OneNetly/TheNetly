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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $featured_image = $_POST['featured_image']; // Add this line
    $download_link = $_POST['download_link']; // Add this line

    // Update post in the database
    $stmt = $pdo->prepare("UPDATE posts SET title = :title, content = :content, featured_image = :featured_image, download_link = :download_link WHERE id = :post_id");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':featured_image', $featured_image, PDO::PARAM_STR); // Add this line
    $stmt->bindParam(':download_link', $download_link, PDO::PARAM_STR); // Add this line
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "Post updated successfully.";
        // Redirect to view post page or any other desired page
        exit;
    } else {
        echo "Error updating post.";
    }
}
?>
<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        /* Adjustments for small screens */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="sidebar bg-gray-800 text-gray-100 w-64 space-y-6 py-7 px-2 md:relative md:translate-x-0 transition duration-200 ease-in-out">
        <!-- Logo -->
        <a href="#" class="text-white flex items-center space-x-2 px-4">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 12h18m-9 8h9"></path>
            </svg>
            <!-- Text -->
            <span class="text-lg font-semibold">Dashboard</span>
        </a>
        <!-- Navigation Links -->
        <nav>
            <a href="./dashboard.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">Dashboard</a>
            <a href="./add_post.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">Add Post</a>
            <a href="./add_categories.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">Add Categories</a>
            <a href="./logout.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">Logout</a>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="content flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b shadow-sm">
            <div class="container mx-auto px-4 py-2">
                <h1 class="text-lg font-semibold">Admin Dashboard</h1>
                <!-- Welcome message -->
                <p>Welcome, <?php echo $_SESSION["username"]; ?>!</p>
            </div>
        </header>
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4">
            <!-- Edit Post Form -->
            <div class="max-w-lg mx-auto">
                <h1 class="text-2xl font-semibold mb-4">Edit Post</h1>
                <form method="post">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                        <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
                        <textarea id="content" name="content" rows="4" cols="50" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"><?php echo $post['content']; ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image:</label>
                        <input type="text" id="featured_image" name="featured_image" value="<?php echo $post['featured_image']; ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="download_link" class="block text-sm font-medium text-gray-700">Download Link:</label>
                        <input type="text" id="download_link" name="download_link" value="<?php echo $post['download_link']; ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Post
                    </button>
                </form>
            </div>
        </main>
    </div>

    <!-- Toggle Button -->
    <div class="md:hidden">
        <button class="fixed bottom-0 left-0 p-4 bg-gray-800 text-gray-100 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition duration-200 ease-in-out">
            <!-- Hamburger Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Include Tailwind CSS for responsive behavior -->
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
</body>
</html>
