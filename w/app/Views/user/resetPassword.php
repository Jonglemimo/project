<?php $this->layout('layout', ['title' => 'Réinitialisation du mot de passe']);
$this->start('main_content');?>

<form action="#" id="changePassword" method="POST">
    <div>
        <label for="pass1">Modification du mot de passe : </label>
        <input type="password" id="pass1" name="pass1" placeholder="Mot de passe"><br>
        <?php if (isset($errors['empty']['pass1'])) : ?>
            <div class="alert-danger">
                <p>Le champ modification du mot de passe est vide</p>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['pass1'])) : ?>
            <div class="alert-danger">
                <p>Le mot de passe doit comprendre entre 8 et 30 caractères</p>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="pass2">Confirmation du mot de passe : </label>
        <input type="password" name="pass2" placeholder="Confirmation"><br>
        <?php if (isset($errors['empty']['pass1'])) : ?>
            <div class="alert-danger">
            <p>Le champ confirmation du mot de passe est vide</p>
            </div>
        <?php endif; ?>
    </div>
    <div>
        <button type="submit" name="changePassword">Mettre à jour</button>
    </div>

</form>
<?php
$this->stop('main_content')
?>