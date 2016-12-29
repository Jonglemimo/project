
<?php

$this->layout('layout', ['title' => 'Modifier vos informations']);
$this->start('main_content');?>

<section class="user-info">

    <a href="<?=$this->url('user_admin')?>">< Retour à ma page</a>

    <form method="POST">
        
        <!-- USERNAME -->
        <label>Pseudonyme</label>
        <input class="body-inputs form-control" type="text" name="username" value="<?=$user['username']?>">
        
        <!-- empty username -->
        <?php if(isset($errors['username']['empty'])) : ?>
            <p>Votre pseudonyme est vide</p>
        <?php endif ?>
        
        <!-- already used username -->
        <?php if(isset($errors['username']['exist'])) : ?>
            <p>Ce pseudonyme existe déjà</p>
        <?php endif ?>
        

        <!-- EMAIL -->
        <label>E-mail</label>
        <input class="body-inputs form-control" type="email" name="email" value="<?=$user['email']?>">

        <!-- empty email -->
        <?php if(isset($errors['email']['empty'])) : ?>
            <p>L'email est vide</p>
        <?php endif ?>
        
        <!-- unvalid email -->
        <?php if(isset($errors['email']['wrong'])) : ?>
            <p>L'email n'est pas valide</p>
        <?php endif ?>

        <!-- already used email -->
        <?php if(isset($errors['email']['exist'])) : ?>
            <p>Cet email existe déjà</p>
        <?php endif ?>

        <!-- SENDING BUTTON -->
        <button class="buttons btn btn-default" type="submit" name="signup">Valider</button>

        <!-- FORGET PASSWORD LINK -->
        <a href="<?=$this->url('user_lostpass')?>">Mot de passe oublié ?</a>
    </form>
</section>

<?php $this->stop('main_content') ?>
