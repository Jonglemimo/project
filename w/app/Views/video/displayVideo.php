
<div class="row col-md-12">
    <?php foreach ($videos as $video): ?>
        <div class='col-md-3'>
            <div class='homepage-container'>
                <h4 class="video-title"><a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>"><img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$video['id_user'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>"><span><?=$video['title'] ?></span></a>
                </h4>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php if($pagination['total'] > 1): ?>
    <div class="row col-md-12 text-center">
        <ul class="pagination ajax">
            <?php for($i = 1; $i <= $pagination['total']; $i ++):?>
                <li<?= $i == $pagination['current'] ? ' class="active"':''?>>
                    <a href="<?=$this->url('search_page',['page' => $i])?>"><?=$i?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
<?php endif; ?>

