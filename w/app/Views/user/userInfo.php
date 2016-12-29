<?php $this->layout('layout', ['title' => 'Modifier mes informations']) ?>

<?php $this->start('main_content') ?>

    <nav><a href="<?=$this->url('default_home')?>">Retour à la galerie</a></nav>

    <form method="POST">
        Pseudonyme : <input class="form-control" type="text" name="username" value="<?php if(isset($user)) echo $user['username']?>"><br>
                <?php if(isset($errors['username']['empty'])) : ?>
            <p>Votre username est vide</p>
        <?php endif ?>

                <?php if(isset($errors['username']['exist'])) : ?>
            <p>Cet username existe déjà</p>
        <?php endif ?>

            email : <input class="form-control" type="email" name="email" value="<?php if(isset($user)) echo $user['email']?>"><br>
        <?php if(isset($errors['email']['empty'])) : ?>
            <p>L'email est vide</p>
        <?php endif ?>

                <?php if(isset($errors['email']['wrong'])) : ?>
            <p>L'email n'est pas valide</p>
        <?php endif ?>


                <?php if(isset($errors['email']['exist'])) : ?>
            <p>Cet email existe déjà</p>
        <?php endif ?>
        <button class="btn btn-default" type="submit" name ="modifyInfo">Valider</button>
        <a class="pull-right" href="<?=$this->url('user_lostpass')?>">Mot de passe oublié ?</a>
    </form>

<?php $this->stop('main_content') ?>
