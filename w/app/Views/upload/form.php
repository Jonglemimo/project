<?php

$this->layout('layout', ['title' => isset($videoEncoding)?'Vidéos en attentes' : 'Ajouter une vidéo']);
$this->start('main_content');
?>
<?php if(isset($videoEncoding)):?>
<div id="currentTranscoding">
    <div class="videoEncoding" style="width: <?= count($videoEncoding)*324?>px">
        <?php foreach ($videoEncoding as $video): ?>
           <div class="wrap-video" data-id="<?=$video['id']?>">
                <div class="overlay"></div>
                <img  src="<?=$this->assetUrl('users'.'/'.$_SESSION['user']['id'].'/'.$video['shortTitle'].'/'.$video['poster_sm'])?>" alt="<?=$video['title']?>">
                <div class="wrap-loader<?=($video['encoding'] != 2 ) ? ' hide' : ''?>">
                    <svg class="loader-circle" width="50" height="50">
                        <circle cx=25 cy=25 r=12 />
                    </svg>
                </div>
           </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?= isset($videoEncoding) ? '<h1>Ajouter une vidéo</h1>' : '' ?>
    <form id="formUpload" method="POST" enctype="multipart/form-data">
        <p  class="hide" id="status"></p>
        <p  class="hide" id="empty"></p>
        <p  class="hide" id="order"></p>
        <dialog open class="hide" id="result"></dialog>
        <input id="imageFile" type="hidden" name="image">
        <input id="videoFile" type="hidden" name="video">
        <div class="form-group">

            <?php if(isset($errors['title'])) : ?>
                <p><?=$errors['title']?></p>
            <?php endif;?>
            Titre : <input class="form-control title" type="text" name="title"><br>
        </div>
        <div class="form-group">
            <select name="categories"  class="form-control">
                <option value="first" selected>Catégories</option>
            </select>
        </div>
        <div class="form-group">
            <?php if(isset($errors['description'])) : ?>
                <p><?=$errors['description']?></p>
            <?php endif ?>

            Description : <textarea class="form-control description" name="description" cols="30" rows="10"></textarea>
        </div>
        <ul class="hide paddingNone" id="listItems">
        </ul>
        <div class="form-group">
            <?php if(isset(  $errors['file']['pictures'])) : ?>
                <p><?=   $errors['file']['pictures']?></p>
            <?php endif ?>
            <div id="submitUploadForm">
                <label id="uploadButton" for="files"><i class="glyphicon glyphicon-open"></i><span id="UploadText">Envoyer une image</span><input class="form-control" data-url="<?=$this->url('upload_form')?>" id="fileupload" type="file" name="files[]" multiple></label>
                <p>(Merci d'upload une vidéo ainsi qu'une image la représentant)</p>
            </div>
        </div>

    </form>
<?php $this->stop('main_content') ?>
<?php $this->start('script')?>
<script src="<?=$this->assetUrl('js/upload.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.ui.widget.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.iframe-transport.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.fileupload.js')?>"></script>
<script src="<?=$this->assetUrl('js/video-progress.js')?>"></script>

<?php $this->stop('script')?>

