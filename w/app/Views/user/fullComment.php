<?php
$this->layout('layout', ['title' => 'Mes commentaires','categories' => $categories]);
$this->start('main_content');
?>

<h1>Mes commentaires</h1>

<!-- FULL COMMENTS -->
<section class="container-fluid main-comment-container">
    <?php if(is_array($comments)):?>
        <?php foreach ($comments as $comment):?>
            <div class="col-md-6">
                <div class="col-sm-12 col-md-6">

                    <!-- VIDEO WHERE THE COMMENTS WAS ADDED -->
                    <a href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>">
                        <img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$comment['id_user'].DIRECTORY_SEPARATOR.$comment['shortTitle'].DIRECTORY_SEPARATOR.$comment['poster_sm']) ?>" alt="<?=$comment['title']?>">
                    </a>
                </div>
                
                <!-- VIDEO TITLE AND COMMENT -->
                <div class="video-comments col-sm-12 col-md-6">


                <button class="btn btn-danger glyphicon glyphicon-trash deleteVideo" data-toggle="confirmation"  data-btn-ok-label="Supprimer"  data-btn-ok-class="btn-danger"  data-btn-cancel-class="btn-default" data-btn-cancel-label="Annuler" data-placement="top" data-delete="<?=$comment['id']?>"></button>
                    <h5><a href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>"><p>Sur : </p><?=$comment['title'] ?></a></h5>

                    <p><?= substr($comment['content'], 0, 220); if(strlen($comment['content']) > 220){ echo " [...]";} ?></p>

                </div>
            </div>
        <?php endforeach;?>

    <!-- IF NO COMMENTS -->
    <?php else: ?>
        <p class="no-content"><?=$comments?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>
<?php $this->start('script')?>

<script src="<?=$this->assetUrl('js/bootstrap-confirmation.min.js')?>"></script>
<script src="<?=$this->assetUrl('js/edit-video.js')?>"></script>

<?php $this->stop('script')?>
