<?php 

$this->layout('layout', ['title' => 'Mot de passe oublié ?']);
$this->start('main_content');?>

<form class="lostpassword" action="#" id="insert-user" method="POST">

    <a href="<?=$this->url('default_home')?>">< Retour à la page d'accueil</a><br>

    <input error class="form-control" type="text" name="mail" value="<?php if (isset($mail)) echo $mail ?>" placeholder="E-mail">
    
    <!-- UNVALID EMAIL -->
    <?php if (isset($errors['mail'])) : ?>
        <div class="false"><p>L'adresse mail n'est pas valide</p></div>
    <?php endif; ?>

    <!-- EMAIL NOT FOUND IN DATABASE -->
    <?php if(isset($errors['wrongEmail'])):?>
        <div class="what"><p>L'adresse mail n'existe pas en base de données</p></div>
    <?php endif; ?>

    <!-- NO EMAIL -->
    <?php if(isset($errors['empty'])):?>
        <div class="meh"><p>L'adresse mail est vide</p></div>
    <?php endif; ?>

    <button class="buttons btn btn-default" type="submit" name="reset-password">Envoyer</button>

</form>

<?php $this->stop('main_content') ?>