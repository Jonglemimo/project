<form action="#" id="changePassword" method="POST">
    <div>
        <label for="pass1">Modification du mot de passe : </label>
        <input type="password" id="pass1" name="pass1" placeholder="Mot de passe"><br>
        <?php if (isset($errors) && $errors['pass1'] == true) : ?>
            <div class="alert-danger">
                <p>Le mot de passe doit comprendre entre 8 et 30 caractères</p>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <label for="pass2">Confirmation du mot de passe : </label>
        <input type="password" name="pass2" placeholder="Confirmation"><br>
        <?php if (isset($errors) && $errors['pass2'] == true) : ?>
            <div class="alert-danger">
            <p>Les mots de passe ne correspondent pas</p>
            </div>
        <?php endif; ?>
    </div>
    <div>
        <button type="submit" name="changePassword">Mettre à jour</button>
    </div>
    <?php if(isset($errors) && $errors['wrongEmail'] == true):?>
        <div class="alert-danger">
            <p>L'adresse mail n'existe pas en base de donnée</p>
        </div>
    <?php endif; ?>
</form>