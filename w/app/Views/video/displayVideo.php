<?php 

foreach ($videos as $video):
	$url = 'users/'.$video['userId'].'/'.$video['shortTitle'].'/'.$video['poster_sm']?>
    <div class='col-md-4'>
        <div class='homepage-container'>
			
			<!-- SHOWING VIDEOS -->
            <a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>">
            <img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>">

            <!-- VIDEO TITLE -->
            <h4 class="video-title"><?=$video['title'] ?></h4>
            </a>
        </div>
    </div>
<?php endforeach; ?>