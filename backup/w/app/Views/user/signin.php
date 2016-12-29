<?php
$this->layout('layout', ['title' => 'Connexion']);
$this->start('main_content');
?>

<section class="login">
    <form class="form-group" method="post">
        
        <!-- EMAIL OR USERNAME -->
        <label>E-mail ou pseudonyme</label>
        <input class="body-inputs form-control" type="text" name="emailOrUsername">
        
        <!-- empty email or username -->
        <?php if(isset($errors['emailOrUsername'])):?>
            <p class="meh">Veuillez renseigner votre email ou pseudo</p>
        <?php endif; ?>


        <!-- PASSWORD -->
        <label>Mot de passe</label>
        <input class="body-inputs form-control" type="password" name="password">
        
        <!-- empty password -->
        <?php if(isset($errors['password'])):?>
            <p class="meh">Veuillez renseigner le mot de passe</p>
        <?php endif; ?>


        <!-- SENDING BUTTON -->
        <button class="buttons btn btn-default" type="submit" name="signin">Connexion</button>

        <!-- FORGET PASSWORD LINK -->
        <a href="<?=$this->url('user_lostpass')?>">Mot de passe oublié ?</a>
        
        <!-- wrong informations -->
        <?php if(isset($errors['echec'])):?>
            <p class="false">Les identifiants sont incorrects</p>
        <?php endif; ?>
    </form>
</section>

<?php $this->stop('main_content') ?>