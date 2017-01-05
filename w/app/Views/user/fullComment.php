<?php
$this->layout('layout', ['title' => 'Mes commentaires','categories' => $categories]);
$this->start('main_content');
?>

<section class="container-fluid main-comment-container">

    <?php if(is_array($comments)):?>
        <?php foreach ($comments as $comment):?>

            <div class="col-md-6">
                <div class="col-sm-12 col-md-6">
                    <video class="video-small" src="<?=$video['url']?>" controls poster="<?= $video['poster'] ?>"></video>
                </div>

                <div class="video-comments col-sm-12 col-md-6">
                <button class="btn btn-danger glyphicon glyphicon-trash deleteVideo" data-toggle="confirmation"  data-btn-ok-label="Supprimer"  data-btn-ok-class="btn-danger"  data-btn-cancel-class="btn-default" data-btn-cancel-label="Annuler" data-placement="top" data-delete="<?=$comment['id']?>"></button>
                    <h5><p>Sur : </p><?=$comment['title'] ?></h5>
                    <p><?= substr($comment['content'], 0, 220); if(strlen($comment['content']) > 220){ echo " [...]";} ?></p>
                </div>
            </div>

        <?php endforeach;?>
    <?php else: ?>
        <p class="no-content"><?=$comments?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>