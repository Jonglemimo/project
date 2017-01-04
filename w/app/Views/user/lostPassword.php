<?php 
$this->layout('layout', ['title' => 'Mot de passe oublié ?','categories' => $categories]);
$this->start('main_content');
?>

<form class="lost-password" action="#" id="insert-user" method="POST">
    
    <!-- RETURN TO HOMEPAGE -->
    <a href="<?=$this->url('default_home')?>">< Retour à la page d'accueil</a><br>

    <!-- success email -->
    <?php if(isset($success)): ?>
        <div class="correct"><p><?=$success?></p></div>
    <?php endif; ?>

    <!-- unvalid email -->
    <?php if (isset($errors['mail'])) : ?>
        <div class="meh"><p><?=$errors['mail']?></p></div>
    <?php endif; ?>

    <!-- email not found in database -->
    <?php if(isset($errors['wrongEmail'])):?>
        <div class="what"><p><?=$errors['wrongEmail']?></p></div>
    <?php endif; ?>

    <!-- empty email -->
    <?php if(isset($errors['empty'])):?>
        <div class="wrong"><p><?=$errors['empty']?></p></div>
    <?php endif; ?>

    <!-- LOST EMAIL -->
    <label>E-mail</label>
    <input error class="body-inputs form-control" type="text" name="mail" value="<?php if (isset($mail)) echo $mail ?>">
    
    <!-- SENDING BUTTON -->
    <button class="buttons btn btn-default" type="submit" name="reset-password">Envoyer</button>
</form>

<?php $this->stop('main_content') ?>