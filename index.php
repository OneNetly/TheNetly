<!DOCTYPE html>
<html>
<head>
    <title>TechSpecs Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-4">TechSpecs Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            require_once 'database.php';

            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="bg-white rounded-lg shadow-md p-4">';
                    echo '<h2 class="text-xl font-bold mb-2">' . $row['name'] . '</h2>';
                    echo '<p class="text-gray-600 mb-4">' . $row['description'] . '</p>';
                    echo '<p class="text-lg font-bold">Price: $' . $row['price'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products found.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>