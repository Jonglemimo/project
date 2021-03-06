<?php
$this->layout('layout', ['title' => 'Mes vidéos','categories' => $categories]);
$this->start('main_content');
?>

<h1>Mes vidéos</h1>

<section class="container-fluid main-video-container">
    <?php if(is_array($videos)):?>
        <div class="row col-md-12">
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
        <?php if($pagination['total'] > 1): ?>
            <div class="row col-md-12 text-center">
                <ul class="pagination">
                    <?php for($i = 1; $i <= $pagination['total']; $i ++):?>
                        <li<?= $i == $pagination['current'] ? ' class="active"':''?>>
                            <a href="<?=$this->url('user_video_page',['page' => $i])?>"><?=$i?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
         <?php endif; ?>
    <!-- IF NO VIDEOS -->
    <?php else: ?>
        <p class="no-content"><?=$videos ?></p>
    <?php endif; ?>
</section>

<?php $this->stop('main_content');?>
<?php $this->start('script')?>
<script src="<?=$this->assetUrl('js/bootstrap-confirmation.min.js')?>"></script>
<script src="<?=$this->assetUrl('js/edit-video.js')?>"></script>
<?php $this->stop('script')?>
