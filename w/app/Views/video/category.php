<?php $this->layout('layout',  ['title' => 'Catégorie : '.ucfirst($currentCategory), 'categories' => $categories]);

$this->start('main_content');
?>

<h1>Catégorie : <?=ucfirst($currentCategory)?></h1>

<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">

<section class="container-fluid main-video-container">
    <?php if(isset($videosByCategory) && count($videosByCategory) > 0):?>
        <div class="row col-md-12">
            <?php foreach ($videosByCategory as $video): ?>
                <div class="col-md-3">
                    <div class="video">
                        <h4 class="video-title"><a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>"><img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$video['id_user'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>"><span><?=$video['title'] ?></span></a>
                        </h4>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <?php if($pagination['total'] > 1): ?>
            <div class="row col-md-12 text-center">
                <ul class="pagination">
                    <?php for($i = 1; $i <= $pagination['total']; $i ++):?>
                        <li<?= $i == $pagination['current'] ? ' class="active"':''?>>
                            <a href="<?=$this->url('user_videos_page',['slug' => $currentCategory, 'page' => $i])?>"><?=$i?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p class="no-content">Cette catégorie ne contient aucune vidéo</p>
    <?php endif; ?>

</section>


<?php $this->stop('main_content') ?>
