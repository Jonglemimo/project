<?php $this->layout('layout', ['title' => 'Créer un nouveau compte']) ?>

<?php $this->start('main_content') ?>

    <nav><a href="<?=$this->url('default_home')?>">Retour à la galerie</a></nav>

    <form method="POST">

        Pseudonyme : <input class="form-control" type="text" name="username" value="<?=$user['username']?>"><br>
                <?php if(isset($errors['username']['empty'])) : ?>
            <p>Votre username est vide</p>
        <?php endif ?>

                <?php if(isset($errors['username']['exist'])) : ?>
            <p>Cet username existe déjà</p>
        <?php endif ?>

            email : <input class="form-control" type="email" name="email" value="<?=$user['email']?>"><br>
        <?php if(isset($errors['email']['empty'])) : ?>
            <p>L'email est vide</p>
        <?php endif ?>

                <?php if(isset($errors['email']['wrong'])) : ?>
            <p>L'email n'est pas valide</p>
        <?php endif ?>


                <?php if(isset($errors['email']['exist'])) : ?>
            <p>Cet email existe déjà</p>
        <?php endif ?>
        <a href="<?=$this->url('user_lostpass')?>">Mot de passe oublié ?</a>
        <button class="btn btn-default" type="submit" name="signup">Valider</button>
    </form>

<?php $this->stop('main_content') ?>
