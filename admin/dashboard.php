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
</head>
<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="bg-gray-800 text-gray-100 w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
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
    <div class="flex-1 flex flex-col overflow-hidden">
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
            <!-- Content goes here -->
            <div class="container mx-auto">
                <p>This is the main content area of the admin dashboard.</p>
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
