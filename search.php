<?php
require_once 'config.php';

// Retrieve the search query and page number from the GET parameters
$query = $_GET['query'] ?? '';
$page = $_GET['page'] ?? 1;
$resultsPerPage = 10;

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
    $title = isset($item['title']) ? $conn->real_escape_string($item['title']) : '';
    $url = isset($item['link']) ? $conn->real_escape_string($item['link']) : '';
    $description = isset($item['snippet']) ? $conn->real_escape_string($item['snippet']) : '';

    // Calculate the relevance score based on the title and description
    $titleRelevance = substr_count(strtolower($title), strtolower($query));
    $descriptionRelevance = substr_count(strtolower($description), strtolower($query));
    $relevanceScore = $titleRelevance * 2 + $descriptionRelevance;

    // Insert the search result into the database with the relevance score
    $sql = "INSERT INTO search_results (title, url, description, relevance_score) VALUES ('$title', '$url', '$description', $relevanceScore)";
    $conn->query($sql);
}

// Retrieve the total count of search results
$sql = "SELECT COUNT(*) AS total FROM search_results WHERE title LIKE '%$query%' OR description LIKE '%$query%'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalResults = $row['total'];
$totalPages = ceil($totalResults / $resultsPerPage);

// Retrieve the search results from the database ordered by relevance score
$offset = ($page - 1) * $resultsPerPage;
$sql = "SELECT * FROM search_results
        WHERE title LIKE '%$query%' OR description LIKE '%$query%'
        ORDER BY relevance_score DESC
        LIMIT $offset, $resultsPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #4285F4;
        }
        .search-input {
            width: 100%;
            max-width: 600px;
            height: 48px;
            border: none;
            border-radius: 24px;
            padding: 0 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }
        .search-button {
            background-color: #4285F4;
            border: none;
            border-radius: 4px;
            color: white;
            padding: 12px 24px;
            margin-left: 16px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #3367D6;
        }
        .result-title {
            font-size: 20px;
            color: #1a0dab;
            margin-bottom: 8px;
        }
        .result-title a {
            color: #1a0dab;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .result-title a:hover {
            color: #3367D6;
            text-decoration: underline;
        }
        .result-url {
            color: #006621;
            margin-bottom: 8px;
        }
        .result-description {
            color: #545454;
            line-height: 1.6;
        }
        .result-stats {
            color: #70757a;
            font-size: 14px;
            margin-top: 8px;
        }
        .pagination {
            margin-top: 32px;
            display: flex;
            justify-content: center;
        }
        .pagination a {
            margin: 0 8px;
            padding: 8px 16px;
            background-color: #4285F4;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .pagination a:hover {
            background-color: #3367D6;
        }
        .pagination a.active {
            background-color: #3367D6;
        }
        @media screen and (max-width: 768px) {
            .logo {
                font-size: 24px;
            }
            .search-input {
                height: 40px;
                padding: 0 16px;
                font-size: 14px;
            }
            .search-button {
                padding: 8px 16px;
                margin-left: 8px;
                font-size: 14px;
            }
            .result-title {
                font-size: 18px;
            }
            .result-description {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-center mb-8">
            <div class="logo">TheNetly</div>
        </div>
        <form id="searchForm" action="search.php" method="GET" class="flex justify-center mb-8">
            <input type="text" id="searchInput" name="query" value="<?php echo $query; ?>" class="search-input" placeholder="Enter your search query">
            <button type="submit" class="search-button">Search</button>
        </form>
        <div id="suggestionBox" class="bg-white border border-gray-300 rounded p-4 mb-8" style="display: none;"></div>
        <div id="searchResults">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="mb-8 bg-white p-6 rounded shadow">
                    <div class="result-title"><a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['title']; ?></a></div>
                    <div class="result-url"><?php echo $row['url']; ?></div>
                    <div class="result-description"><?php echo $row['description']; ?></div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="pagination">
            <?php if ($totalResults > 0): ?>
                <?php if ($page > 1): ?>
                    <a href="search.php?query=<?php echo urlencode($query); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="search.php?query=<?php echo urlencode($query); ?>&page=<?php echo $i; ?>" <?php if ($i === $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="search.php?query=<?php echo urlencode($query); ?>&page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const suggestionBox = document.getElementById('suggestionBox');

        searchInput.addEventListener('input', function () {
            const query = this.value;
            if (query.length > 2) {
                axios.get('search_suggestions.php', {
                    params: {
                        query: query
                    }
                })
                .then(function (response) {
                    const suggestions = response.data;
                    suggestionBox.innerHTML = '';
                    suggestions.forEach(function (suggestion) {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.className = 'py-2 cursor-pointer hover:bg-gray-100';
                        suggestionItem.textContent = suggestion;
                        suggestionItem.addEventListener('click', function () {
                            searchInput.value = suggestion;
                            suggestionBox.style.display = 'none';
                            searchForm.submit();
                        });
                        suggestionBox.appendChild(suggestionItem);
                    });
                    suggestionBox.style.display = 'block';
                })
                .catch(function (error) {
                    console.error(error);
                });
            } else {
                suggestionBox.style.display = 'none';
            }
        });
    </script>
</body>
</html>