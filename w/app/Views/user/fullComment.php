<?php
$this->layout('layout', ['title' => 'Mes commentaires','categories' => $categories]);
$this->start('main_content');
?>

<h1>Mes commentaires</h1>

<section class="container-fluid main-comment-container">
    <?php if(is_array($comments)):?>
        <?php foreach ($comments as $comment):?>

            <div class="col-md-6">
                <div class="col-sm-12 col-md-6">
                    <a href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>"> <img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$comment['id_user'].DIRECTORY_SEPARATOR.$comment['shortTitle'].DIRECTORY_SEPARATOR.$comment['poster_sm']) ?>" alt="<?=$comment['title']?>">
                    </a>
                </div>

                <div class="video-comments col-sm-12 col-md-6">
                    <h5><a href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>"><p>Sur : </p><?=$comment['title'] ?></a></h5>
                    <p><?= substr($comment['content'], 0, 220); if(strlen($comment['content']) > 220){ echo " [...]";} ?></p>
                </div>
            </div>

        <?php endforeach;?>
    <?php else: ?>
        <p class="no-content"><?=$comments?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>
<?php $this->start('script')?>

<script src="<?=$this->assetUrl('js/bootstrap-confirmation.min.js')?>"></script>
<script src="<?=$this->assetUrl('js/edit-video.js')?>"></script>

<?php $this->stop('script')?>
