<?php if(isset($_GET['id']))?>
<?php include_once 'header.php';?>

<?php
$search = 'https://api.themoviedb.org/3/search/movie?api_key=63fb1e91fb11068f4a55b0a6df305231&query=';
$sid = $_GET['id'];
$jdata = "$search$sid" ?>
<?php
$tsearch = 'https://api.themoviedb.org/3/search/tv?api_key=63fb1e91fb11068f4a55b0a6df305231&query=';
$sid = $_GET['id'];
$tjdata = "$tsearch$sid" ?>
<h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-5 mt-5 text-center">MOVIES RESULTS</h2>
<center><div class="container mx-auto"><span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
			$json_data = file_get_contents($jdata);
			$json = json_decode($json_data, true);
			if(count($json) != 0){
				foreach($json['results'] as $result){
					?>
					<span><a href= "movies.php?id=<?php echo $result['id']; ?>"><img class="w-40" src="https://image.tmdb.org/t/p/w185<?php echo $result['poster_path']; ?>" alt="Image"></a></span>
					<?php
				}
			}
		?>
		</span></div></center>
        <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-5 mt-5 text-center">TV SERIES RESULTS</h2>
		<center><div class="container mx-auto"><span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
			$tjson_data = file_get_contents($tjdata);
			$tjson = json_decode($tjson_data, true);
			if(count($tjson) != 0){
				foreach($tjson['results'] as $tresult){
					?>
					<span><a href= "tv.php?id=<?php echo $tresult['id'];?>&s=1&e=1"><img class="w-40" src="https://image.tmdb.org/t/p/w185<?php echo $tresult['poster_path']; ?>" alt="Image"></a></span></a>
					<?php
				}
			}
		?>
		</span></div></center>

<?php include_once 'footer.php'?>