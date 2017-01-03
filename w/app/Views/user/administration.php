<?php
$this->layout('layout', ['title' => '']);
$this->start('main_content');
?>

<div class="userpage-banner">
    <?php if(!empty($user['avatar'])):?>
    <img src="<?= $this->assetUrl('users'.DIRECTORY_SEPARATOR.$user['id'].DIRECTORY_SEPARATOR.$user['avatar']) ?>" alt="Votre avatar">
    <?php else: ?>
    <img src="http://gurucul.com/wp-content/uploads/2015/01/default-user-icon-profile.png" alt="Votre avatar">
    <?php endif; ?>


    <div>
        <p class="username"><?= $_SESSION['user']['username'] ?></p>
        <a href="<?=$this->url('user_info')?>">Mes infos</a>
    </div>
</div>

<section class="container-fluid video-container">

    <h3>Mes vidéos</h3>

    <a class="buttons btn btn-default pull-right" href="<?=$this->url('upload_form')?>">Ajouter une vidéo</a>

    <?php if(is_array($videos)):?>

        <div class="latest-video row col-md-12">
            <?php foreach ($videos as $video):?>
                <div class="col-md-4">
                    <div class="video">
                        <?php if ($video['id_user'] === $_SESSION['user']['id']):?>
                            <input class="deleteId" type="hidden" value="<?=$this->url('delete_video')?>">
                            <button class="btn btn-danger glyphicon glyphicon-trash deleteVideo" data-toggle="confirmation"  data-btn-ok-label="Supprimer"  data-btn-ok-class="btn-danger"  data-btn-cancel-class="btn-default" data-btn-cancel-label="Annuler" data-placement="top" data-delete="<?=$video['id_video']?>" ></button>
                            <button class="btn btn-default glyphicon glyphicon-edit editVideo"  data-edit="<?=$this->url('edit_video', ['id'=> $video['id_video']])?>"></button>
                        <?php endif; ?>
                        <video class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['url'])?>" controls poster="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>"></video>
                    </div>
                    <h4><?=$video['title'] ?></h4>
                    <p><?= substr($video['description'], 0, 100); if(strlen($video['description']) > 100){ echo " [...]";} ?></p>
                </div>
            <?php endforeach;?>
        </div>

    <div>
        <a href="<?=$this->url('user_video')?>">Voir plus</a>
    </div>

    <?php else :?>
        <p><?= $videos ?></p>
    <?php endif; ?>  
</section>

<section class="container-fluid comment-container">

    <h3>Mes commentaires</h3>

    <?php if(is_array($comments)):?>
        <?php foreach ($comments as $comment):?>

            <div class="col-md-6">
                <div class="col-sm-12 col-md-6">
                    <video class="video-small" src="<?=$video['url']?>" controls poster="<?= $video['poster'] ?>"></video>
                </div>

                <div class="video-comments col-sm-12 col-md-6">
                    <h5><p>Sur : </p><?=$comment['title'] ?></h5>
                    <p><?= substr($comment['content'], 0, 220); if(strlen($comment['content']) > 220){ echo " [...]";} ?></p>
                </div>
            </div>
        <?php endforeach;?>

    <div>
        <a href="<?=$this->url('user_comment')?>" class = "col-md-offset-7">Voir plus</a>
    </div>

    <?php else :?>
        <p><?= $comments ?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>
<?php $this->start('script')?>

<script src="<?=$this->assetUrl('js/edit-video.js')?>"></script>
<script src="<?=$this->assetUrl('js/bootstrap-confirmation.min.js')?>"></script>

<?php $this->stop('script')?>
