<?php

$this->layout('layout_upload', ['title' => 'Formulaire d\'envoi']);
$this->start('main_content');
?>
    <form id="fileupload" method="POST" enctype="multipart/form-data">
        <p>Choix du poster de la vidéo</p>
        <fieldset>
            <?php if(isset($errors['title'])) : ?>
                <p><?=$errors['title']?></p>
            <?php endif ?>
            Titre : <input type="text" name="pictureTitle"><br>
            <?php if(isset(  $errors['file']['pictures'])) : ?>
                <p><?=   $errors['file']['pictures']?></p>
            <?php endif ?>
            Image à upload : <input type="file" name="pictureUrl"><br>
        </fieldset>

        <fieldset>
            <p>Choix de la vidéo</p>

           Titre : <input type="text" name="videoTitle">
        </fieldset>
        <?php if(isset($errors['description'])) : ?>
            <p><?=$errors['description']?></p>
        <?php endif ?>
<?php $this->stop('script')?>
