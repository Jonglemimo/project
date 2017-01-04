<?php
$this->layout('layout', ['title' => 'Mes vidéos']);
$this->start('main_content');
?>

<section class="container-fluid main-video-container">
    <?php if(is_array($videos)):?>

        <div class="row col-md-12">
            <?php foreach ($videos as $video):?>
                <div class="col-md-4">
                    <div class="video">
                        <video class="video-medium" src="<?=$this->assetUrl(DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['url'])?>" controls poster="<?=$this->assetUrl(DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>"></video>
                    </div>
                    <h4><?=$video['title'] ?></h4>
                    <p><?= substr($video['description'], 0, 100); if(strlen($video['description']) > 100){ echo " [...]";} ?></p>
                </div>
            <?php endforeach;?>
        </div>

    <?php else: ?>
        <p class="no-content"><?=$videos ?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content');?>
<?php $this->start('script')?>
<script src="<?=$this->assetUrl('js/edit-video.js')?>"></script>

<?php $this->stop('script')?>
