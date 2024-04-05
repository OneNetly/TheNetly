<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import and Play YouTube Video</title>
    <link href="https://vjs.zencdn.net/7.16.0/video-js.css" rel="stylesheet">
</head>
<body>

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

// Function to fetch video details from YouTube API
function fetchVideoDetails($videoId, $api_key) {
    $api_url = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$videoId&key=$api_key";
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    return $data['items'][0]['snippet'];
}

if (isset($_GET['video_id'])) {
    $videoId = $_GET['video_id'];

    // Check if video already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE video_id = ?");
    $stmt->execute([$videoId]);
    $existingVideo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingVideo) {
        // Fetch video details from YouTube API
        $video_details = fetchVideoDetails($videoId, 'AIzaSyCLEd18z88RqKxn_0x_BdblkKP9F56wb0w');
        $title = $video_details['title'];
        $thumbnailUrl = $video_details['thumbnails']['medium']['url'];
        $publishedAt = $video_details['publishedAt'];

        // Insert video details into the database
        $stmt = $pdo->prepare("INSERT INTO videos (video_id, title, thumbnail_url, published_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$videoId, $title, $thumbnailUrl, $publishedAt]);
    }

    // Display the video using Video.js
    echo "<video
              id='video-js-player'
              class='video-js vjs-default-skin'
              controls
              preload='auto'
              width='640'
              height='360'
              data-setup='{}'
              >
                <source src='https://www.youtube.com/watch?v=$videoId' type='video/youtube'>
            </video>";

} else {
    echo "Invalid request";
}
?>

<script src="https://vjs.zencdn.net/7.16.0/video.min.js"></script>
<script src="https://vjs.zencdn.net/7.16.0/plugins/youtube/videojs-youtube.min.js"></script>
<script>
    // Initialize Video.js player
    videojs('video-js-player', {
        techOrder: ['youtube'],
        autoplay: false // Set to true if you want the video to play automatically
    });
</script>
</body>
</html>
