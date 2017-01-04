<?php

$this->layout('layout', ['title' => 'Inscription réussie !','categories' => $categories]);
$this->start('main_content') ?>

<section class="signin-success">

    <!-- USERNAME -->
    <label>Votre pseudonyme : </label>
    <p><?= $user['username'] ?></p>
    <br>
    <!-- EMAIL -->
    <label>Votre e-mail : </label>
    <p><?= $user['email'] ?></p>

    <!-- RETURN TO HOMEPAGE -->
    <a href="<?=$this->url('default_home')?>">< Retour sur la page home</a>

</section>

<?php $this->stop('main_content')?>
