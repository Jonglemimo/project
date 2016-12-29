<?php 

	foreach ($videos as $video) {
		$url = 'uploads/images/medium/'.$video['poster'];
		echo "<div id='videoInfoSmall'>";
		echo "<img src='".$this->assetUrl($url)."' data-unique='".$video['shortTitle']."'>";
		echo "<h2>".$video['title']."</h2>";
		echo "<p>".$video['description']."</p>";
		echo "</div>";
	}