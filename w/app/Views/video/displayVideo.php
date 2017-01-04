<?php 

	foreach ($videos as $video) {
		$url = 'users/'.$video['userId'].'/'.$video['shortTitle'].'/'.$video['poster_sm'];
		echo "<a href='".$this->url('watch',['shortTitle' => $video['shortTitle']])."'>";
		echo "<div id='videoInfoSmall'>";
		echo "<img src='".$this->assetUrl($url)."' data-shortTitle='".$video['shortTitle']."'>";
		echo "<h2>".$video['title']."</h2>";
		echo "<p>".$video['description']."</p>";
		echo "</div>";
		echo "</a>";
	}