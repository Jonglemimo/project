<?php $this->layout('layout', ['title' => 'Mot de passe oublié']);
$this->start('main_content');?>
<form action="#" id="insert-user" method="POST">
    <input error type="text" name="mail" value="<?php if (isset($mail)) echo $mail ?>" placeholder="E-mail"><br>
    <?php if (isset($errors['mail'])) : ?>
        <div class="alert alert-danger"><p>L'adresse n'est pas valide</p></div>
    <?php endif; ?>
    <?php if(isset($errors['wrongEmail'])):?>
        <div class="alert alert-danger"><p>L'adresse mail n'exsiste pas en base de donnée</p></div>
    <?php endif; ?>
    <?php if(isset($errors['empty'])):?>
        <div class="alert alert-danger"><p>L'adresse mail est vide</p></div>
    <?php endif; ?>
    <button type="submit" name="reset-password">Envoyer</button>
    <a href="<?=$this->url('default_home')?>">Retour à la page d'accueil</a>
</form>
<?php
$this->stop('main_content')
?>