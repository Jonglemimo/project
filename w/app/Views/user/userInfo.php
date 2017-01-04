<?php
$this->layout('layout', ['title' => 'Modifier vos informations','categories' => $categories]);
$this->start('main_content');
?>

<section class="user-info">

    <a href="<?=$this->url('user_admin')?>">< Retour à ma page</a>


    <form  method="POST" enctype="multipart/form-data">

        <!-- Message success modif -->
        <?php if (isset($success)):?>
            <div class="correct"><p><?=$success?></p></div>
        <?php endif; ?>

        <!-- Message status modif -->
        <?php if (isset($status)):?>
            <div class="what"><p><?=$status?></p></div>
        <?php endif; ?>


        <!-- USERNAME -->
        <label>Pseudonyme</label>
        <input class="body-inputs form-control" type="text" name="username" value="<?=$user['username']?>">
        
        <!-- empty username -->
        <?php if(isset($errors['username']['empty'])) : ?>
            <div class="what"><p><?=$errors['username']['empty']?></p></div>
        <?php endif ?>
        
        <!-- already used username -->
        <?php if(isset($errors['username']['exist'])) : ?>
            <div class="false"><p><?=$errors['username']['exist']?></p></div>
        <?php endif ?>
        

        <!-- EMAIL -->
        <label>E-mail</label>
        <input class="body-inputs form-control" type="email" name="email" value="<?=$user['email']?>">

        <!-- empty email -->
        <?php if(isset($errors['email']['empty'])) : ?>
        <div class="what"><p><?=$errors['email']['empty']?></p></div>
        <?php endif ?>
        
        <!-- unvalid email -->
        <?php if(isset($errors['email']['wrong'])) : ?>
            <div class="false"><p><?=$errors['email']['wrong']?></p></div>
        <?php endif ?>

        <!-- already used email -->
        <?php if(isset($errors['email']['exist'])) : ?>
            <div class="false"><p><?=$errors['email']['exist']?></p></div>
        <?php endif ?>


        <label for="pass1">Nouveau mot de passe</label>
        <input value="<?php if(isset($pass['pass1'])) echo $pass['pass1']?>" class="body-inputs form-control" type="password" id="pass1" name="pass1">

        <!-- empty password -->
        <?php if (isset($errors['empty']['pass'])) : ?>
            <div class="what"><p><?=$errors['empty']['pass']?></p></div>
        <?php endif; ?>

        <!-- short password -->
        <?php if (isset($errors['lenght']['pass1'])) : ?>
            <div class="false"><p><?=$errors['lenght']['pass1']?></p></div>
        <?php endif; ?>


        <!-- CONFIRM PASSWORD -->
        <label for="pass2">Confirmation du mot de passe</label>
        <input value="<?php if(isset($pass['pass2'])) echo $pass['pass2']?>" class="body-inputs form-control" type="password" name="pass2">

        <?php if (isset($errors['pass']['different'])) : ?>
            <div class="false"><p><?=$errors['pass']['different']?></p></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="picture">Avatar</label>
            <input type="file" name="picture">
        </div>

        <?php if (isset($errors['picture'])) : ?>
            <div class="false"><p><?=$errors['picture']?></p></div>
        <?php endif; ?>

        <!-- SENDING BUTTON -->
        <button class="buttons btn btn-default" type="submit" name="modifyInfo">Valider</button>
    </form>
</section>

<?php $this->stop('main_content') ?>
