<?php 

	foreach ($videos as $video):
		$url = 'users/'.$video['userId'].'/'.$video['shortTitle'].'/'.$video['poster_sm']?>
        <div class='col-md-4'>
            <div class='homepage-container'>
                <h4 class="video-title"><a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>"> <img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>"><?=$video['title'] ?> </a>
                </h4>
            </div>
        </div>
    <?php endforeach; ?>