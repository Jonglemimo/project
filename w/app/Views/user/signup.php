<?php $this->layout('layout', ['title' => 'Créer un nouveau compte']) ?>

<?php $this->start('main_content') ?>

<section class="signup">

    <nav>
        <a href="<?=$this->url('default_home')?>">< Retour à la page d'accueil</a>
    </nav>

    <form method="POST">

        <!-- FIRSTNAME -->
        <label>Prénom</label>
        <input class="form-control" type="text" name="firstname">

        <?php if(isset($errors['firstname']['empty'])) : ?>
            <p class="meh">Le prénom est vide</p>
        <?php endif ?>
        
        <?php if(isset($errors['firstname']['wrong'])) : ?>
            <p class="false">Le prénom n'est pas valide</p>
        <?php endif ?>


        <!-- LASTNAME -->
        <label>Nom</label>
        <input class="form-control" type="text" name="lastname">

        <?php if(isset($errors['lastname']['empty'])) : ?>
            <p class="meh">Le nom est vide</p>
        <?php endif ?>
        
        <?php if(isset($errors['lastname']['wrong'])) : ?>
            <p class="false">Le nom n'est pas valide</p>
        <?php endif ?>
        

        <!-- USERNAME -->
        <label>Pseudonyme</label>
        <input class="form-control" type="text" name="username">

        <?php if(isset($errors['username']['empty'])) : ?>
            <p class="meh">Votre pseudonyme est vide</p>
        <?php endif ?>
        
        <?php if(isset($errors['username']['exist'])) : ?>
            <p class="false">Cet username existe déjà</p>
        <?php endif ?>
        

        <!-- EMAIL -->
        <label>E-mail</label>
        <input class="form-control" type="email" name="email">

        <?php if(isset($errors['email']['empty'])) : ?>
            <p class="meh">L'email est vide</p>
        <?php endif ?>

        <?php if(isset($errors['email']['wrong'])) : ?>
            <p class="false">L'email n'est pas valide</p>
        <?php endif ?>

        <?php if(isset($errors['email']['exist'])) : ?>
            <p class="false">Cet email est déjà utilisé</p>
        <?php endif ?>


        <!-- PASSWORD -->
        <label>Mot de passe</label>
        <input class="form-control" type="password" name="password">

        <?php if(isset($errors['password']['empty'])) : ?>
            <p class="meh">Précisez un mot de passe</p>
        <?php endif ?>

        <?php if(isset($errors['password']['short'])) : ?>
            <p class="false">Votre mot de passe est inférieur à 5 caractères</p>
        <?php endif ?>


        <!-- VALIDATE -->
        <button class="buttons btn btn-default" type="submit" name="signup">Valider</button>

    </form>
</section>

<?php $this->stop('main_content') ?>