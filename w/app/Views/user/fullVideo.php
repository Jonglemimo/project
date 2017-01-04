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
                        <?php if ($video['id_user'] === $_SESSION['user']['id']):?>
                            <input class="deleteId" type="hidden" value="<?=$this->url('delete_video')?>">
                            <button class="btn btn-danger glyphicon glyphicon-trash deleteVideo" data-toggle="confirmation"  data-title="Supprimer la vidéo ?" data-btn-ok-label="Supprimer"  data-btn-ok-class="btn-danger"  data-btn-cancel-class="btn-default" data-btn-cancel-label="Annuler" data-placement="top" data-delete="<?=$video['id_video']?>" ></button>
                            <button class="btn btn-default glyphicon glyphicon-edit editVideo"  data-edit="<?=$this->url('edit_video', ['id'=> $video['id_video']])?>"></button>
                        <?php endif; ?>
                        <a href="<?=$this->url('watch',['shortTitle' => $video['shortTitle']])?>">
                            <img class="video-medium" src="<?=$this->assetUrl('users'.DIRECTORY_SEPARATOR.$_SESSION['user']['id'].DIRECTORY_SEPARATOR.$video['shortTitle'].DIRECTORY_SEPARATOR.$video['poster_sm']) ?>" alt="<?=$video['title']?>"></img>
                    </div>
                            <h4><?=$video['title'] ?></h4>
                        </a>
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
