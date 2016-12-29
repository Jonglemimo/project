<?php
$this->layout('layout', ['title' => 'Créer un nouveau compte']);
$this->start('main_content');
?>

<section class="signup">

    <a href="<?=$this->url('default_home')?>">< Retour à la page d'accueil</a>

    <form method="POST">

        <!-- FIRSTNAME -->
        <label>Prénom</label>
        <input class="body-inputs form-control" type="text" name="firstname">
        
        <!-- empty firstname -->
        <?php if(isset($errors['firstname']['empty'])) : ?>
            <p class="meh">Le prénom est vide</p>
        <?php endif ?>
        
        <!-- unvalid firstname -->
        <?php if(isset($errors['firstname']['wrong'])) : ?>
            <p class="false">Le prénom n'est pas valide</p>
        <?php endif ?>


        <!-- LASTNAME -->
        <label>Nom</label>
        <input class="body-inputs form-control" type="text" name="lastname">
        
        <!-- empty lastname -->
        <?php if(isset($errors['lastname']['empty'])) : ?>
            <p class="meh">Le nom est vide</p>
        <?php endif ?>
        
        <!-- unvalid lastname -->
        <?php if(isset($errors['lastname']['wrong'])) : ?>
            <p class="false">Le nom n'est pas valide</p>
        <?php endif ?>
        

        <!-- USERNAME -->
        <label>Pseudonyme</label>
        <input class="body-inputs form-control" type="text" name="username">
        
        <!-- empty username -->
        <?php if(isset($errors['username']['empty'])) : ?>
            <p class="meh">Votre pseudonyme est vide</p>
        <?php endif ?>
        
        <!-- unvalid username -->
        <?php if(isset($errors['username']['exist'])) : ?>
            <p class="false">Cet username existe déjà</p>
        <?php endif ?>
        

        <!-- EMAIL -->
        <label>E-mail</label>
        <input class="body-inputs form-control" type="email" name="email">

        <!-- empty email -->
        <?php if(isset($errors['email']['empty'])) : ?>
            <p class="meh">L'email est vide</p>
        <?php endif ?>
        
        <!-- unvalid email -->
        <?php if(isset($errors['email']['wrong'])) : ?>
            <p class="false">L'email n'est pas valide</p>
        <?php endif ?>
        
        <!-- already used email -->
        <?php if(isset($errors['email']['exist'])) : ?>
            <p class="false">Cet email est déjà utilisé</p>
        <?php endif ?>


        <!-- PASSWORD -->
        <label>Mot de passe</label>
        <input class="body-inputs form-control" type="password" name="password">
        
        <!-- need password -->
        <?php if(isset($errors['password']['empty'])) : ?>
            <p class="meh">Précisez un mot de passe</p>
        <?php endif ?>
        
        <!-- short password -->
        <?php if(isset($errors['password']['short'])) : ?>
            <p class="false">Votre mot de passe est inférieur à 5 caractères</p>
        <?php endif ?>


        <!-- SENDING BUTTON -->
        <button class="buttons btn btn-default" type="submit" name="signup">Valider</button>
    </form>
</section>

<?php $this->stop('main_content') ?>