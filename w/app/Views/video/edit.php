<?php
$this->layout('layout', ['title' => 'Edition de votre vidéo','categories' => $categories]);
$this->start('main_content');
?>
<h1>Edition de votre vidéo</h1>
<a class="edit-videos-a" href="<?=$this->url('user_admin')?>">< Retour à ma page</a>

<form id="edit" method="POST" enctype="multipart/form-data">

    <p class="hide" id="status"></p>
    <p class="hide" id="empty"></p>

    <dialog open class="hide" id="result"></dialog>

    <input id="modifyUrl" type="hidden" value="<?=$this->url('edit_video', ['id'=> $infoVideo['video']['id']])?>">

    <div class="form-group">
        <span>Titre</span>
        <input class="body-inputs form-control title" type="text" name="title" value="<?=$infoVideo['video']['title']?>">

        <label for="categories">Catégories</label>
        <select  name="categories" class="body-inputs form-control category">
            <option value="<?=$infoVideo['currentCategory']['id']?>" selected><?=$infoVideo['currentCategory']['name']?></option>
            <?php foreach ($infoVideo['categories'] as $category):?>
                <?php if($category['id'] != $infoVideo['currentCategory']['id']):?>
                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <label>Description</label>
        <textarea class="body-inputs form-control description" name="description" rows="5"><?=$infoVideo['video']['description']?></textarea>
    </div>

    <ul class="hide paddingNone" id="listItems"></ul>

    <div class="form-group">
        <button class="buttons btn btn-default" type="submit">Modifier</button>
    </div>
</form>

<?php $this->stop('main_content') ?>
<?php $this->start('script')?>
<script src="<?=$this->assetUrl('js/modify-video.js')?>"></script>
<?php $this->stop('script')?>

