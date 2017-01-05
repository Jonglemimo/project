<?php 

    foreach ($videos as $video):
    $url = 'users/'.$video['userId'].'/'.$video['shortTitle'].'/'.$video['poster_sm']?>
    <div class='col-md-3'>
        <div class='homepage-container'>
            <h4 class="video-title"><a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>"><img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$video['id_user'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>"><span><?=$video['title'] ?></span></a>
            </h4>
        </div>
    </div>
    </div>
<?php endforeach; ?>