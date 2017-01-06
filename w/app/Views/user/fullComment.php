<?php
$this->layout('layout', ['title' => 'Mes commentaires','categories' => $categories]);
$this->start('main_content');
?>

<h1>Mes commentaires</h1>

<!-- FULL COMMENTS -->
<section class="container-fluid main-comment-container">
    <?php if(is_array($comments)):?>
       <div class="row col-md-12 latest-video">
            <?php foreach ($comments as $comment) : ?>

                <!-- COMMENTS APPEARING UNDER FULL VIDEO PAGE -->
                <div class="watch-comments col-md-4">
                    <div class="avatar-comments">
                        <!-- USER AVATAR -->
                        <a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>"> <img src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$comment['id_user'].DIRECTORY_SEPARATOR.$comment['shortTitle'].DIRECTORY_SEPARATOR.$comment['poster_sm'])?>" alt="Votre avatar"></a>

                    </div>

                    <!-- DATE OF THE COMMENT AND AUTHOR -->
                    <div class="date-user-comments">

                        <h5 class="title-date"><a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>">Le <span class="date"><?= $comment['date_posted'] ?></span> sur la video : <?=$comment['title']?></a></h5>

                    </div>

                    <!-- COMMENT CONTENT -->
                    <p class="text-comments"><?= $comment['content'] ?></p>
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
