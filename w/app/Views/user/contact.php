<?php
$this->layout('layout', ['title' => 'Contact','categories' => $categories]);
$this->start('main_content');
?>

<section class="container-fluid">

    <a href="<?=$this->url('user_admin')?>">< Retour à ma page</a>
    <?php if(isset($success)):?>
        <p class="correct"><?=$success?></p>
    <?php endif;?>
    <?php if(isset($fail)):?>
        <p class="false"><?=$fail?></p>
    <?php endif;?>
    <?php if(isset($errors['subject']['empty'])):?>
        <p class="false"><?=$errors['subject']['empty']?></p>
    <?php endif;?>
    <?php if(isset($errors['subject']['empty'])):?>
        <p class="false"><?=$errors['content']['empty']?></p>
    <?php endif;?>

    <form method="POST">
        <label for="subject">Sujet </label>
        <input class="body-inputs form-control" type="text" name="subject">
        <label for="content">Contenu </label>
        <textarea class="body-inputs form-control" name="content" cols="30" rows="10"></textarea>
        <!-- SENDING BUTTON -->
        <button class="buttons btn btn-default" type="submit" name="contact">Valider</button>
    </form>
</section>

<?php $this->stop('main_content') ?>
