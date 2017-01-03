
<?php $this->layout('layout',  ['title' => 'Catégorie : '.$videosByCategory[0]['name']  ]);


$this->start('main_content');

?>
<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">


<section class="container-fluid main-video-container">
    <?php if(isset($videosByCategory) && count($videosByCategory) > 0):?>
        <div class="row col-md-12 lastest-video">
            <?php foreach ($videosByCategory as $video): ?>
                <div class="col-md-2">
                    <div class="video ">
                        <video class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['url'])?>" controls poster="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>"></video>
                    </div>
                    <h4><?=$video['title'] ?></h4>
                    <p><?= substr($video['description'], 0, 100); if(strlen($video['description']) > 100){ echo " [...]";} ?></p>
                </div>
            <?php endforeach;?>
        </div>
    <?php else: ?>
        <p>Cette catégorie ne contient aucune vidéo</p>
    <?php endif; ?>
</section>


<?php $this->stop('main_content') ?>
