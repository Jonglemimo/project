<?php $this->layout('layout', ['title' => 'Connexion']);

$this->start('main_content');?>

    <section class="login">
        <form class="form-group" method="post">
            <fieldset>
                <?php if(isset($errors['emailOrUsername'])):?>
                    <p>Veuillez remplir votre email</p>
                <?php endif; ?>
                <input class="form-control" type="text" name="emailOrUsername" placeholder="E-mail">
                <?php if(isset($errors['password'])):?>
                    <p>Veuillez remplir le mot de passe</p>
                <?php endif; ?>
                <input class="form-control" type="password" name="password" placeholder="Mot de passe">
            </fieldset>
            <button class="btn btn-default" type="submit" name="signin">Connexion</button>
            <?php if(isset($errors['echec'])):?>
                <p>Les identifiants sont incorrects</p>
            <?php endif; ?>
        </form>
    </section>

<?php $this->stop('main_content') ?>