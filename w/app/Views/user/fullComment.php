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
                    <a href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>">
                        <span>Sur : </span><h4 class="comment-title"><?=$comment['title'] ?></h4>
                    </a>

                    <p><?= substr($comment['content'], 0, 150); if(strlen($comment['content']) > 150){ echo " [...]";} ?></p>
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
