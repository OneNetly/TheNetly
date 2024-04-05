<?php
require_once 'config.php';

// Create a new MySQLi object and establish a database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Make a request to the Google Search API
$url = "https://www.googleapis.com/customsearch/v1?key=" . GOOGLE_API_KEY . "&cx=" . GOOGLE_SEARCH_ENGINE_ID . "&q=" . urlencode($query) . "&start=" . (($page - 1) * $resultsPerPage + 1);
$response = file_get_contents($url);
$data = json_decode($response, true);

// Store the search results in the database
foreach ($data['items'] as $item) {
    $title = $conn->real_escape_string($item['title']);
    $url = $conn->real_escape_string($item['link']);
    $description = $conn->real_escape_string($item['snippet']);

    // Calculate the relevance score based on the title and description
    $titleRelevance = substr_count(strtolower($title), strtolower($query));
    $descriptionRelevance = substr_count(strtolower($description), strtolower($query));
    $relevanceScore = $titleRelevance * 2 + $descriptionRelevance;

    // Get related keywords for the search result
    $relatedKeywords = implode(',', getRelatedKeywords($query, $title, $description));

    // Insert the search result into the database with the relevance score and related keywords
    $sql = "INSERT INTO search_results (title, url, description, relevance_score, related_keywords) VALUES ('$title', '$url', '$description', $relevanceScore, '$relatedKeywords')";
    $conn->query($sql);
}

$conn->close();

// Function to get related keywords for a search result
function getRelatedKeywords($query, $title, $description) {
    // You can use a third-party API or your own algorithm to generate related keywords
    // based on the input query, title, and description.
    // For example, you could use a natural language processing library, or a simple approach
    // like extracting the most frequent words from the text.
    // Here's a simple example using frequent words:
    $text = strtolower($query . ' ' . $title . ' ' . $description);
    $words = array_count_values(str_word_count($text, 1));
    arsort($words);
    $relatedKeywords = array_keys(array_slice($words, 0, 5, true));

    return $relatedKeywords;
}