<?php
$this->layout('layout', ['title' => 'Mes vidéos']);
$this->start('main_content');
?>

<section class="container-fluid main-video-container">
    <?php if(is_array($videos)):?>

        <div class="row col-md-12">
            <?php foreach ($videos as $video):?>

                <div class="col-md-4">

                    <video class="video-medium embed-responsive-item" src="<?=$video['url']?>" controls poster="<?= $video['poster'] ?>"></video>
                    <h4><?=$video['title'] ?></h4>
                    <p><?= substr($video['description'], 0, 100); if(strlen($video['description']) > 100){ echo " [...]";} ?></p>

                </div>
            <?php endforeach;?>
        </div>

    <?php else: echo $videos ?>
<?php endif; ?>
</section>

<?php $this->stop('main_content');?>