<?php
$this->layout('layout', ['title' => 'Réinitialiser votre mot de passe','categories' => $categories]);
$this->start('main_content');
?>

<h1>Réinitialiser votre mot de passe</h1>

<form action="#" id="changePassword" method="POST">

    <!-- EDITING PASSWORD -->
    <label for="pass1">Nouveau mot de passe</label>
    <input class="body-inputs form-control" type="password" id="pass1" name="pass1" placeholder="Mot de passe">
    
    <!-- empty password -->
    <?php if (isset($errors['empty']['pass1'])) : ?>
        <div class="what"><p>Le champ modification du mot de passe est vide</p></div>
    <?php endif; ?>
    
    <!-- short password -->
    <?php if (isset($errors['pass1'])) : ?>
        <div class="false"><p>Le mot de passe doit comprendre entre 8 et 30 caractères</p></div>
    <?php endif; ?>

    <!-- CONFIRM PASSWORD -->
    <label for="pass2">Confirmation du nouveau mot de passe</label>
    <input class="body-inputs form-control" type="password" name="pass2" placeholder="Confirmation">
    
    <!-- empty confirm password -->
    <?php if (isset($errors['empty']['pass1'])) : ?>
        <div class="false"><p>Le champ confirmation du mot de passe est vide</p></div>
    <?php endif; ?>
    
    <!-- SENDING BUTTON -->
    <button class="buttons btn btn-default" type="submit" name="changePassword">Mettre à jour</button>
</form>

<?php $this->stop('main_content') ?>