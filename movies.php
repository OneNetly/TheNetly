<?php if(isset($_GET['id']))
include 'config.php';
$str1="https://api.themoviedb.org/3/movie/";
$str2="?api_key=63fb1e91fb11068f4a55b0a6df305231";
$sid = $_GET['id'];
$jsondata = "$str1$sid$str2";
$json = file_get_contents($jsondata);
$jo = json_decode($json);
$str3="https://api.themoviedb.org/3/movie/";
$str4="/images?api_key=63fb1e91fb11068f4a55b0a6df305231";
$ijsondata = "$str3$sid$str4";
$ijson = file_get_contents($ijsondata);
$ijo = json_decode($ijson,true);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php echo $jo->overview;?>">
    <link rel="stylesheet" href="/css/output.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="/assets/icon.png">
    <title><?php echo $jo->original_title;?> <?php echo $SEOtag;?></title>
	<meta name="keywords" content="<?php echo $jo->original_title;?> free download,<?php echo $jo->original_title;?> watch online,<?php echo $jo->original_title;?> free,<?php echo $jo->original_title;?> download,<?php echo $jo->original_title;?> drive link,<?php echo $jo->original_title;?> movie download by link">
	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo $jo->original_title;?> <?php echo $SEOtag;?>">
	<meta property="og:site_name" content="<?php echo $Name;?>">
	<meta property="og:url" content="<?php echo $URL;?>/movies?id=<?php echo $jo->id;?>">
	<meta property="og:description" content="<?php echo $jo->overview;?>">
	<meta property="og:image" content="https://www.themoviedb.org/t/p/w533_and_h300_bestv2<?php echo $ijo['backdrops'][0]['file_path'];?>">
	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?php echo $URL;?>/movies?id=<?php echo $jo->id;?>">
	<meta property="twitter:title" content="<?php echo $jo->original_title;?> <?php echo $SEOtag;?>">
	<meta property="twitter:description" content="<?php echo $jo->overview;?>">
	<meta property="twitter:image" content="https://www.themoviedb.org/t/p/w533_and_h300_bestv2<?php echo $ijo['backdrops'][0]['file_path'];?>">
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
<div class="container mx-auto"><form action="/search" method="GET">
    <div class="relative">
        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" name="id" value="<?php if(isset($_GET['id']))?>" class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type any Movie or TV Series Name...." autocomplete="off" required="">
        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
    </div>
</form></div>

<br>
<body>

<?php
$js1 = '<script type="application/ld+json">';
$js2 = '</script>';
?>

<?php echo $js1; ?>
{
	"@context": "https://schema.org",
	"@type": "BlogPosting",
	"mainEntityOfPage": {
		"@type": "WebPage",
		"@id": "<?php echo $URL; ?>/movies?id=<?php echo $jo->id; ?>"
	},
	"headline": "<?php echo $jo->original_title; ?>",
	"description": "<?php echo $jo->overview; ?>",
	"image": "https://image.tmdb.org/t/p/w185<?php echo $jo->poster_path; ?>",
	"author": {
		"@type": "Organization",
		"name": "<?php echo $Name; ?>"
	},
	"datePublished": "<?php echo $jo->release_date; ?>"
}
<?php echo $js2; ?>

<div class="container mx-auto aspect-w-16 aspect-h-8">
<iframe src="https://www.2embed.to/embed/tmdb/movie?id=<?php echo $sid;?>" scrolling="no" allowfullscreen></iframe></div>
<br>
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">

    <div class="flex flex-wrap -m-4">
      <div class="p-4 lg:w-1/2">
        <div class="h-full flex sm:flex-row flex-col items-center sm:justify-start justify-center text-center sm:text-left">
          <img alt="team" class="flex-shrink-0 rounded-lg w-64 h-auto object-cover object-center sm:mb-0 mb-4" src="https://image.tmdb.org/t/p/w185/<?php echo $jo->poster_path;?>">
          <div class="flex-grow sm:pl-8">
            <h2 class="title-font font-medium text-lg text-gray-900"><?php echo $jo->original_title;?></h2>
            <p class="mb-auto"><?php echo $jo->overview;?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$s1 = "https://api.themoviedb.org/3/movie/";
$s2 = "/similar?api_key=63fb1e91fb11068f4a55b0a6df305231"; ?>

<center><div class="container mx-auto"><span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
			$json_data = "$s1$sid$s2";
            $qjson = file_get_contents($json_data);
			$ajson = json_decode($qjson, true);
			if(count($ajson) != 0){
				foreach($ajson['results'] as $result){
					?>
					<span><a href= "movies?id=<?php echo $result['id'];?>"><img class="w-40" src="https://image.tmdb.org/t/p/w185<?php echo $result['poster_path']; ?>" alt="Image"></a></span>
					<?php
				}
			}
		?>
		</span></div></center>
<?php include_once 'footer.php'?>