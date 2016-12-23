<?php 
	echo $search;
	echo "<br>";
	foreach ($videos as $video) {
		echo "<img src='".$video['url']."'>";
		echo "<h2>".$video['title']."</h2>";
		echo "<p>".$video['description']."</p>";
	}