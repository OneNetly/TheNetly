<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest YouTube Videos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">

<?php
// Establish database connection
$host = '207.244.240.126';
$dbname = 'thenetly_home';
$username = 'thenetly_home';
$password = 'AmiMotiur27@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to fetch latest videos from YouTube API
function fetchLatestVideos($api_key, $max_results = 10) {
    $api_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&order=date&maxResults=$max_results&key=$api_key";
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    return $data['items'];
}

// Display latest videos
$api_key = 'AIzaSyCLEd18z88RqKxn_0x_BdblkKP9F56wb0w';
$videos = fetchLatestVideos($api_key);

echo "<h1 class='text-3xl font-bold mb-4'>Latest YouTube Videos</h1>";
echo "<div class='grid grid-cols-2 md:grid-cols-4 gap-4'>";

foreach ($videos as $video) {
    $videoId = $video['id']['videoId'];
    $title = $video['snippet']['title'];
    $thumbnailUrl = $video['snippet']['thumbnails']['medium']['url'];
    $publishedAt = $video['snippet']['publishedAt'];

    // Check if video already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE video_id = ?");
    $stmt->execute([$videoId]);
    $existingVideo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingVideo) {
        echo "<a href='import.php?video_id=$videoId' class='block'><img src='$thumbnailUrl' alt='$title' class='w-full'></a>";
    } else {
        echo "<img src='$thumbnailUrl' alt='$title' class='w-full'>";
    }
}

echo "</div>";
?>
</body>
</html>
