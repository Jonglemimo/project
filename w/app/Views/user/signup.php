<?php $this->layout('layout', ['title' => 'Créer un nouveau compte']) ?>

<?php $this->start('main_content') ?>

    <nav><a href="<?=$this->url('default_home')?>">< Retour à la galerie</a></nav>

    <form method="POST">
        Prénom : <input class="form-control" type="text" name="firstname"><br>
        <?php if(isset($errors['firstname']['empty'])) : ?>
            <p>Le prénom est vide</p>;
        <?php endif ?>

        <?php if(isset($errors['firstname']['wrong'])) : ?>
            <p>Le prénom n'est pas valide</p>
        <?php endif ?>

        Nom : <input class="form-control" type="text" name="lastname"><br>
        <?php if(isset($errors['lastname']['empty'])) : ?>
            <p>Le nom est vide</p>
        <?php endif ?>

        <?php if(isset($errors['lastname']['wrong'])) : ?>
            <p>Le nom n'est pas valide</p>
        <?php endif ?>


        Pseudonyme : <input class="form-control" type="text" name="username"><br>
        <?php if(isset($errors['username']['empty'])) : ?>
            <p>Votre username est vide</p>
        <?php endif ?>

        <?php if(isset($errors['username']['exist'])) : ?>
            <p>Cet username existe déjà</p>
        <?php endif ?>

        email : <input class="form-control" type="email" name="email"><br>
        <?php if(isset($errors['email']['empty'])) : ?>
            <p>L'email est vide</p>
        <?php endif ?>

        <?php if(isset($errors['email']['wrong'])) : ?>
            <p>L'email n'est pas valide</p>
        <?php endif ?>


        <?php if(isset($errors['email']['exist'])) : ?>
            <p>Cet email existe déjà</p>
        <?php endif ?>


        Mot de passe : <input class="form-control" type="password" name="password">
        <?php if(isset($errors['password']['empty'])) : ?>
            <p>Précisez un mot de passe</p>
        <?php endif ?>

        <?php if(isset($errors['password']['short'])) : ?>
            <p>Votre mot de passe est inférieur à 5 caractères</p>
        <?php endif ?>

        <button class="btn btn-default" type="submit" name="signup">Valider</button>
    </form>
<?php $this->stop('main_content') ?>