<?php

$this->layout('layout', ['title' => 'Inscription réussie !']);
$this->start('main_content') ?>

<section class="signin-success">
	
    <label>Votre pseudonyme : </label>
    <p><?= $user['username'] ?></p>
	<br>
    <label>Votre e-mail : </label>
    <p><?= $user['email'] ?></p>

	<a href="<?=$this->url('default_home')?>">< Retour sur la page home</a>

</section>

<?php $this->stop('main_content')?>
