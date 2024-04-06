<?php include 'config.php';
if(isset($_GET['id']))?> <?php if(isset($_GET['s']))?> <?php if(isset($_GET['e']))
$str1="https://api.themoviedb.org/3/tv/";
$str2="?api_key=63fb1e91fb11068f4a55b0a6df305231";
$sid = $_GET['id'];
$e = $_GET['e'];
$s = $_GET['s'];
$ts = "/season/";
$semilar = "/similar";
$sjsondata = "$str1$sid$ts$s$str2";
$sjson = file_get_contents($sjsondata);
$sjo = json_decode($sjson);
$jsondata = "$str1$sid$str2";
$json = file_get_contents($jsondata);
$jo = json_decode($json);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php echo $jo->overview;?>">
	<meta name="author" content="<?php echo $author;?>">
    <link rel="stylesheet" href="/css/output.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="/assets/icon.png">
    <title><?php echo $jo->name;?> <?php echo $SEOtag;?></title>
	<meta name="keywords" content="<?php echo $jo->name;?> free download,<?php echo $jo->name;?> watch online,<?php echo $jo->name;?> free,<?php echo $jo->name;?> download,<?php echo $jo->name;?> drive link,<?php echo $jo->name;?> movie download by link">
	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo $jo->name;?> <?php echo $SEOtag;?>">
	<meta property="og:site_name" content="<?php echo $Name;?>">
	<meta property="og:url" content="<?php echo $URL;?>/tv.php?id=<?php echo $sid = $_GET['id'];?>&s=<?php echo $s = $_GET['s']; ?>&e=<?php echo $s = $_GET['e']; ?>">
	<meta property="og:description" content="<?php echo $jo->overview;?>">
	<meta property="og:image" content="https://www.themoviedb.org/t/p/w533_and_h300_bestv2<?php echo $jo->backdrop_path;?>">
	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?php echo $URL;?>/tv.php?id=<?php echo $sid = $_GET['id'];?>&s=<?php echo $s = $_GET['s']; ?>&e=<?php echo $s = $_GET['e']; ?>">
	<meta property="twitter:title" content="<?php echo $jo->name;?> <?php echo $SEOtag;?>">
	<meta property="twitter:description" content="<?php echo $jo->overview;?>">
	<meta property="twitter:image" content="https://www.themoviedb.org/t/p/w533_and_h300_bestv2<?php echo $jo->backdrop_path;?>">

</head>
<header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <a href = "/"><span class="ml-3 text-xl"><?php echo $Name;?></span></a>
    </a>
  </div>
</header>
<br>
<div class="container mx-auto">
	<form action="/search.php" method="GET">
	<div class="relative">
        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" name="id" value="<?php if(isset($_GET['id']))?>" class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type any Movie or TV Series Name...." autocomplete="off" required="">
        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
    </div>
</form>
</div>

<br>
<body>
<?php
$js1 = '<script type="application/ld+json">';
$js2 = '</script>';
?>
<?php 
echo $js1;?>

{
	"@context": "https://schema.org",
	"@type": "BlogPosting",
	"mainEntityOfPage": {
	  "@type": "WebPage",
	  "@id": "<?php echo $URL;?>/tv.php?id=<?php echo $sid = $_GET['id'];?>&s=<?php echo $s = $_GET['s']; ?>&e=<?php echo $s = $_GET['e']; ?>"
	},
	"headline": "<?php echo $jo->name;?>",
	"description": "<?php echo $jo->overview;?>",
	"image": "https://image.tmdb.org/t/p/w185<?php echo $jo->poster_path;?>",  
	"author": {
	  "@type": "Organization",
	  "name": "<?php echo $Name;?>"
	},
  }
<?php echo $js2;?>
<div class="container mx-auto aspect-w-16 aspect-h-8">
<iframe src="https://www.2embed.to/embed/tmdb/tv?id=<?php echo $sid;?>&s=<?php echo $s = $_GET['s']; ?>&e=<?php echo $e;?>" allowfullscreen></iframe></div>
<br>

<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap -m-4">
      <div class="p-4 lg:w-1/2">
        <div class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
          <img alt="team" class="flex-shrink-0 rounded-lg w-64 h-auto object-cover object-center sm:mb-0 mb-4" src="https://image.tmdb.org/t/p/w185<?php echo $jo->poster_path;?>">
          <div class="flex-grow sm:pl-8">
            <h2 class="title-font font-medium text-lg text-gray-900"><?php echo $jo->name;?></h2>
            <p class="mb-auto"><?php echo $jo->overview;?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<center>
	<span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
            $tvjson = file_get_contents($sjsondata);
			$ijson = json_decode($tvjson, true);
			if(count($ijson) != 0){
				foreach($ijson['episodes'] as $tepisodes){
					?>
					<a href= "tv?id=<?php echo $sid = $_GET['id'];?>&s=<?php echo $s = $_GET['s']; ?>&e=<?php echo $tepisodes['episode_number']; ?>"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Episode <?php echo $tepisodes['episode_number']; ?></button></a>
					<?php
				}
			}
		?>
		</span>
	</center>
<br>
<center>
	<span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
            $tvjson = file_get_contents($jsondata);
			$ijson = json_decode($tvjson, true);
			if(count($ijson) != 0){
				foreach($ijson['seasons'] as $tvseasons){
					?>
					<a href= "tv?id=<?php echo $sid = $_GET['id'];?>&s=<?php echo $tvseasons['season_number']; ?>&e=1"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Season <?php echo $tvseasons['season_number']; ?></button></a>
					<?php
				}
			}
		?>
	</span>
</center>
<br>
<center>
	<div class="container mx-auto">
		<span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
			$json_data = "$str1$sid$semilar$str2";
            $qjson = file_get_contents($json_data);
			$ajson = json_decode($qjson, true);
			if(count($ajson) != 0){
				foreach($ajson['results'] as $result){
					?>
					<span><a href= "tv?id=<?php echo $result['id'];?>&s=1&e=1"><img class="w-40" src="https://image.tmdb.org/t/p/w185<?php echo $result['poster_path']; ?>" alt="Image"></a></span>
					<?php
				}
			}
		?>
		</span>
	</div>
</center>
<?php include 'footer.php';?>