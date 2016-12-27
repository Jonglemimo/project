<?php

$this->layout('layout', ['title' => 'Formulaire d\'envoi']);
$this->start('main_content');
?>
    <form id="formUpload" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <?php if(isset($errors['title'])) : ?>
                    <p><?=$errors['title']?></p>
                <?php endif ?>
                Titre : <input class="form-control" type="text" name="pictureTitle"><br>
            </div>
            <div class="form-group">
                <?php if(isset($errors['description'])) : ?>
                    <p><?=$errors['description']?></p>
                <?php endif ?>
                Description : <textarea class="form-control" name="description" cols="30" rows="10"></textarea>
            </div>
            <ul class="hide" id="listItems">
            </ul>
            <div class="form-group">
                <?php if(isset(  $errors['file']['pictures'])) : ?>
                    <p><?=   $errors['file']['pictures']?></p>
                <?php endif ?>
                Fichiers à upload : <input class="form-control" data-url="<?=$this->url('upload_form')?>" id="fileupload" type="file" name="files[]" multiple><br>
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

