<?php

$this->layout('layout', ['title' => isset($videoEncoding)?'Vidéos en cours de transcodages' : 'Ajouter une vidéo']);
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
<a href="<?=$this->url('user_admin')?>">< Retour à ma page</a>
<?= isset($videoEncoding) ? '<h1>Ajouter une vidéo</h1>' : '' ?>
    <form id="formUpload" method="POST" enctype="multipart/form-data">
        <p  class="hide" id="status"></p>
        <p  class="hide" id="empty"></p>
        <p  class="hide" id="order"></p>
        <dialog open class="hide" id="result"></dialog>
        <input id="imageFile" type="hidden" name="image">
        <input id="videoFile" type="hidden" name="video">
        <div class="form-group">
            <label for="title">Titre :</label>
           <input class="form-control title" type="text" name="title"><br>
        </div>
        <div class="form-group">
           <select  name="categories"  class="form-control category">
                <option value="first" selected>Catégories</option>
                <?php foreach ($categories as $category):?>
                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description : </label>
            <textarea class="form-control description" name="description" cols="30" rows="10"></textarea>
        </div>
        <ul class="hide paddingNone" id="listItems">
        </ul>
        <div class="form-group">
            <div id="submitUploadForm">
                <label id="uploadButton" for="files"><i class="glyphicon glyphicon-open"></i><span id="UploadText">Envoyer une image</span><input class="form-control" data-url="<?=$this->url('upload_form')?>" id="fileupload" type="file" name="files[]" multiple></label>
                <p>(Merci d'upload une vidéo ainsi qu'une image la représentant)</p>
            </div>
            <button id="submitBtn" type="submit" class="buttons btn btn-default hide">Envoyer</button>
        </div>
    </form>
<?php $this->stop('main_content') ?>
<?php $this->start('script')?>
<script src="<?=$this->assetUrl('js/upload.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.ui.widget.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.iframe-transport.js')?>"></script>
<script src="<?=$this->assetUrl('js/jquery.fileupload.js')?>"></script>
<script src="<?=$this->assetUrl('js/video-progress.js')?>"></script>
<script> var uploadUrl = '<?= $this->url('upload_form')?>'</script>

<?php $this->stop('script')?>

