<?php
$this->layout('layout', ['title' => 'Ma page','categories' => $categories]);
$this->start('main_content');
?>

<div class="userpage-banner">
    <!-- USER AVATAR -->
    <?php if(!empty($user['avatar'])):?>
    <img src="<?= $this->assetUrl('users'.DIRECTORY_SEPARATOR.$user['id'].DIRECTORY_SEPARATOR.$user['avatar']) ?>" alt="Votre avatar">
    <?php else: ?>
    <img src="http://gurucul.com/wp-content/uploads/2015/01/default-user-icon-profile.png" alt="Votre avatar">
    <?php endif; ?>
    
    <!-- USER NAME AND INFORMATIONS LINK -->
    <div>
        <p class="username"><?= ucfirst($_SESSION['user']['username'])?></p>
        <a href="<?=$this->url('user_info')?>">Mes infos</a>
    </div>
</div>

<!-- MY VIDEOS -->
<section class="container-fluid video-container">

    <h3>Mes vidéos</h3>
    
    <!-- BUTTON ADD A VIDEO -->
    <a class="buttons btn btn-default pull-right" href="<?=$this->url('upload_form')?>">Ajouter une vidéo</a>
    <?php if(is_array($videos)):?>
        <div class="row col-md-12 latest-video">
            <?php foreach ($videos as $video):?>
                <div class="col-md-3 col-sm-12">
                    <div class="video">
                        <div class="relative-buttons">
                            <!-- MODIFY OR DELETE VIDEO BUTTONS -->
                            <?php if ($video['id_user'] === $_SESSION['user']['id']):?>
                                    <input class="deleteId" type="hidden" value="<?=$this->url('delete_video')?>">
                                    <button class="btn btn-danger glyphicon glyphicon-trash deleteVideo" data-toggle="confirmation"  data-title="Supprimer la vidéo ?" data-btn-ok-label="Supprimer"  data-btn-ok-class="btn-danger"  data-btn-cancel-class="btn-default" data-btn-cancel-label="Annuler" data-placement="top" data-delete="<?=$video['id_video']?>" ></button>
                                    <button class="btn btn-default glyphicon glyphicon-edit editVideo"  data-edit="<?=$this->url('edit_video', ['id'=> $video['id_video']])?>"></button>
                            <?php endif; ?>
                            
                            <!-- LATEST VIDEOS WITH TITLES -->
                            <h4 class="video-title"><a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>"><img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>"><span><?=$video['title'] ?></span></a>
                            </h4>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    
    <!-- SEE MORE VIDEOS -->
    <div>
        <a class="see-more" href="<?=$this->url('user_video')?>">Voir plus</a>
    </div>
    
    <!-- IF NO VIDEOS -->
    <?php else :?>
        <p class="no-content"><?= $videos ?></p>
    <?php endif; ?>
</section>

<!-- MY COMMENTS -->
<section class="container-fluid comment-container">
    <h3>Mes commentaires</h3>
    <?php if(is_array($comments)):?>

    <div class="row col-md-12 latest-video">
        <?php foreach ($comments as $comment):?>
            <div class="col-md-6">
                <div class="col-sm-12 col-md-6">
                    <a href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>"> <img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$comment['id_user'].DIRECTORY_SEPARATOR.$comment['shortTitle'].DIRECTORY_SEPARATOR.$comment['poster_sm']) ?>" alt="<?=$comment['title']?>">

                    </a>
                </div>
                
                <!-- VIDEO TITLE AND COMMENT -->
                <div class="video-comments col-sm-12 col-md-6">
                    <h5>Sur : <a  href="<?=$this->url('watch',['shortTitle' => $comment['shortTitle']])?>"><span class="comment-title"><?=$comment['title'] ?></span></a></h5>
                    <p><?= substr($comment['content'], 0, 220); if(strlen($comment['content']) > 220){ echo " [...]";} ?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div>
        <a href="<?=$this->url('user_comment')?>" class = "see-more">Voir plus</a>
    </div>
    
    <!-- IF NO COMMENTS -->
    <?php else :?>
        <p class="no-content"><?= $comments ?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>
<?php $this->start('script')?>

<script src="<?=$this->assetUrl('js/bootstrap-confirmation.min.js')?>"></script>
<script src="<?=$this->assetUrl('js/edit-video.js')?>"></script>

<?php $this->stop('script')?>
