<?php 

	foreach ($videos as $video):
		$url = 'users/'.$video['userId'].'/'.$video['shortTitle'].'/'.$video['poster_sm']?>
        <div class='col-md-4'>
            <div class='homepage-container'>
                <a href='<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>'>
                    <img src='<?=$this->assetUrl($url)?>' data-shortTitle='<?=$video['shortTitle']?>'>
                    <h4><?=$video['title']?></h4>
                </a>
            </div>
        </div>
    <?php endforeach; ?>