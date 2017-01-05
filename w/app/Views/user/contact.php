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
    <?php if(!empty($form['errors']['subject']['empty'])):?>
        <p class="meh"><?=$form['errors']['subject']['empty']?></p>
    <?php endif;?>
    <?php if(!empty($form['errors']['content']['empty'])):?>
        <p class="meh"><?=$form['errors']['content']['empty']?></p>
    <?php endif;?>
    <?php if(!empty($form['errors']['email']['empty'])):?>
        <p class="meh"><?=$form['errors']['email']['empty']?></p>
    <?php endif;?>
    <?php if(!empty($form['errors']['email']['wrong'])):?>
        <p class="false"><?=$form['errors']['email']['wrong']?></p>
    <?php endif;?>


    <form method="POST">
        <label for="subject">Sujet</label>
        <input class="body-inputs form-control" type="text" name="subject" value="<?=isset($form['subject'])?$form['subject']:null?>" >
        <label for="email">Email</label>
        <input class="body-inputs form-control" type="email" name="email" value="<?=isset($user['email'])?$user['email']:null?>">
        <label for="content">Contenu</label>
        <textarea class="body-inputs form-control" name="content" cols="30" rows="10"><?=isset($form['content'])?$form['content']:null?></textarea>
        <!-- SENDING BUTTON -->
        <button class="buttons btn btn-default" type="submit" name="contact">Valider</button>
    </form>
</section>

<?php $this->stop('main_content') ?>
