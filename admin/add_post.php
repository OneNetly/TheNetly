<?php
require_once '../config.php';

// Define variables for success message and error message
$success_message = '';
$error_message = '';

// Fetch categories and subcategories from the database
$categories = [];
$stmt = $pdo->query("SELECT * FROM categories WHERE parent_id IS NULL");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $category_id = $row['id'];
    $categories[$category_id] = [
        'name' => $row['name'],
        'subcategories' => []
    ];

    // Fetch subcategories for each category
    $sub_stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = :category_id");
    $sub_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $sub_stmt->execute();
    while ($sub_row = $sub_stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories[$category_id]['subcategories'][$sub_row['id']] = $sub_row['name'];
    }
}

// Add new post to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category'];
    $featured_image = $_POST['featured_image']; // Get the direct link to the featured image
    $download_link = $_POST['download_link']; // Get the direct link for download

    // Insert post into posts table
    $stmt = $pdo->prepare("INSERT INTO posts (title, content, featured_image, download_link) VALUES (:title, :content, :featured_image, :download_link)");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':featured_image', $featured_image, PDO::PARAM_STR);
    $stmt->bindParam(':download_link', $download_link, PDO::PARAM_STR);
    $stmt->execute();

    $post_id = $pdo->lastInsertId();

    // Insert post-category relationship into post_categories table
    $stmt = $pdo->prepare("INSERT INTO post_categories (post_id, category_id) VALUES (:post_id, :category_id)");
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();

    // Set success message
    $success_message = "Post added successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Add New Post</h1>
        <?php if ($success_message): ?>
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="bg-red-200 text-red-800 p-4 rounded mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post" class="space-y-4">
            <div>
                <label for="title" class="block font-semibold">Title</label>
                <input type="text" name="title" id="title" class="w-full border p-2 rounded">
            </div>
            <div>
                <label for="content" class="block font-semibold">Content</label>
                <textarea name="content" id="content" rows="5" class="w-full border p-2 rounded"></textarea>
            </div>
            <div>
                <label for="category" class="block font-semibold">Category</label>
                <select name="category" id="category" class="w-full border p-2 rounded">
                    <?php foreach ($categories as $category_id => $category): ?>
                        <optgroup label="<?php echo $category['name']; ?>">
                            <?php foreach ($category['subcategories'] as $sub_id => $sub_name): ?>
                                <option value="<?php echo $sub_id; ?>"><?php echo $sub_name; ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="featured_image" class="block font-semibold">Featured Image (Direct Link)</label>
                <input type="text" name="featured_image" id="featured_image" class="w-full border p-2 rounded">
            </div>
            <div>
                <label for="download_link" class="block font-semibold">Download Link</label>
                <input type="text" name="download_link" id="download_link" class="w-full border p-2 rounded">
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Add Post</button>
            </div>
        </form>
    </div>
</body>

</html>
