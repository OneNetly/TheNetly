<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreeNetly</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Add custom CSS styles here */
        .dropdown {
            position: relative;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 1;
        }
        .dropdown:hover .dropdown-content,
        .dropdown:focus-within .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="/">
                        <span class="ml-2 text-white">TheNetly</span>
                    </a>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4 justify-end">
                    <!-- Loop through categories -->
                    <?php
                    // Include database configuration file
                    require_once "config.php";

                    // Fetch top-level categories (those with parent_id = NULL)
                    $sql = "SELECT * FROM categories WHERE parent_id IS NULL";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $categoryId = $row['id'];
                        $categoryName = $row['name'];
                        // Check if category has subcategories
                        $hasSubcategories = false;
                        $subSql = "SELECT * FROM categories WHERE parent_id = $categoryId";
                        $subStmt = $pdo->query($subSql);
                        if ($subStmt->rowCount() > 0) {
                            $hasSubcategories = true;
                        }
                        ?>
                        <div class="dropdown relative">
                            <a href="/category.php?id=<?php echo $categoryId; ?>" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"><?php echo $categoryName; ?></a>
                            <!-- Subcategories dropdown -->
                            <?php if ($hasSubcategories) { ?>
                                <ul class="dropdown-content bg-gray-800 text-white rounded-md py-2 absolute hidden">
                                    <?php
                                    while ($subRow = $subStmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <li><a href="/category.php?id=<?php echo $subRow['id']; ?>" class="block px-4 py-2 hover:bg-gray-700"><?php echo $subRow['name']; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            <?php } ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="md:hidden">
                <button class="mobile-menu-button">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="hidden mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <!-- Loop through categories -->
            <?php
            $stmt->execute(); // Reset the statement
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categoryId = $row['id'];
                $categoryName = $row['name'];
                // Check if category has subcategories
                $hasSubcategories = false;
                $subSql = "SELECT * FROM categories WHERE parent_id = $categoryId";
                $subStmt = $pdo->query($subSql);
                if ($subStmt->rowCount() > 0) {
                    $hasSubcategories = true;
                }
                ?>
                <div class="dropdown relative">
                    <a href="/category.php?id=<?php echo $categoryId; ?>" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"><?php echo $categoryName; ?></a>
                    <!-- Subcategories dropdown -->
                    <?php if ($hasSubcategories) { ?>
                        <ul class="dropdown-content bg-gray-800 text-white rounded-md py-2 absolute hidden">
                            <?php
                            while ($subRow = $subStmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <li><a href="/category.php?id=<?php echo $subRow['id']; ?>" class="block px-4 py-2 hover:bg-gray-700"><?php echo $subRow['name']; ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</nav>
<script>
    // Toggle mobile menu visibility
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
