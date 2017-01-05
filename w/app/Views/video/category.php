<?php $this->layout('layout',  ['title' => 'Catégorie : '.ucfirst($currentCategory),'categories' => $categories  ]);

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
    <?php else: ?>
        <p class="no-content">Cette catégorie ne contient aucune vidéo</p>
    <?php endif; ?>
</section>


<?php $this->stop('main_content') ?>
