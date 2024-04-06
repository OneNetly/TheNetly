<?php include_once 'header.php';?>
<h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-5 mt-5 text-center">NOW PLAYING</h2>
<center><div class="container mx-auto"><span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
			$json_data = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=63fb1e91fb11068f4a55b0a6df305231");
			$json = json_decode($json_data, true);
			if(count($json) != 0){
				foreach($json['results'] as $result){
					?>
					<span><a href= "/movies?id=<?php echo $result['id']; ?>"><img class="w-40" src="https://image.tmdb.org/t/p/w185<?php echo $result['poster_path']; ?>" alt="Image"></a></span>
					<?php
				}
			}
		?>
		</span></div></center>

      <h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-5 mt-5 text-center">TV SERIES</h2>


	  <center><div class="container mx-auto"><span class="inline-grid grid-cols-4 sm:grid-cols-4 xl:grid-cols-10 gap-3">
		<?php
			$json_data = file_get_contents("https://api.themoviedb.org/3/tv/top_rated?api_key=63fb1e91fb11068f4a55b0a6df305231");
			$json = json_decode($json_data, true);
			if(count($json) != 0){
				foreach($json['results'] as $result){
					?>
					<span><a href= "/tv?id=<?php echo $result['id']; ?>&s=1&e=1"><img class="w-40" src="https://image.tmdb.org/t/p/w185<?php echo $result['poster_path']; ?>" alt="Image"></a></span>
					<?php
				}
			}
		?>
		</span></div></center>
		<?php include_once 'footer.php';?>
