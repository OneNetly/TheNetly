<?php
require_once 'config.php';

// Retrieve the search query from the GET parameter
$query = $_GET['query'] ?? '';

// Create a new MySQLi object and establish a database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to fetch search suggestions
$stmt = $conn->prepare("SELECT DISTINCT title FROM search_results WHERE title LIKE ? LIMIT 5");
$stmt->bind_param("s", $queryParam);

// Add wildcard characters to the query for partial matching
$queryParam = "%{$query}%";

// Execute the prepared statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the search suggestions as an array
$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row['title'];
}

// Close the statement and the database connection
$stmt->close();
$conn->close();

// Return the search suggestions as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
?>