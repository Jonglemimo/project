<?php $this->layout('layout', ['title' => 'Mes vidéos']);
$this->start('main_content');?>
<section class="container-fluid videoContainer">
    <?php if(is_array($videos)):?>
        <div class="row col-md-12">
            <?php foreach ($videos as $video):?>
                <div class="col-md-4 col-md-push-2 text-center">
                    <video src="<?=$video['url']?>" controls></video>
                    <p><?=$video['title'] ?></p>
                    <p><?=$video['description'] ?></p>
                </div>
            <?php endforeach;?>
        </div>
    <?php else: echo $videos ?>
<?php endif; ?>
</section>
<?php $this->stop('main_content');?>