<?php

$this->layout('layout', ['title' => 'Formulaire d\'envoi']);
$this->start('main_content');
?>
<div id="currentTranscoding" style="height: 200px; overflow-x: auto;overflow-y: hidden">
    <div style="width: 8020px">
        <?php for($i = 0; $i < 20; $i ++) {

           echo '<img src = "http://lorempixel.com/400/200?'.uniqid().'" />';
        } ?>
    </div>
</div>
    <form id="formUpload" method="POST" enctype="multipart/form-data">
        <p  class="hide" id="status"></p>
        <p  class="hide" id="empty"></p>
        <dialog open class="hide" id="result"></dialog>
        <input id="imageFile" type="hidden" name="image">
        <input id="videoFile" type="hidden" name="video">
        <div class="form-group">
            <?php if(isset($errors['title'])) : ?>
                <p><?=$errors['title']?></p>
            <?php endif ?>
            Titre : <input class="form-control title" type="text" name="title"><br>
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

            <label id="uploadButton" for="files"><i class="glyphicon glyphicon-open"></i> Fichiers à upload<input class="form-control" data-url="<?=$this->url('upload_form')?>" id="fileupload" type="file" name="files[]" multiple></label>
        </div>


        <div class="clearfix">
            <button type="submit" class="btn btn-success pull-right">Envoyer</button>
        </div>
    </form>
<?php $this->stop('main_content') ?>
<?php $this->start('script')?>
<script src="<?=$this->assetUrl('js/upload.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.ui.widget.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.iframe-transport.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.fileupload.js')?>"></script>
<?php $this->stop('script')?>

