<?php $this->layout('layout', ['title' => 'Erreur 403']) ?>

<?php $this->start('main_content'); ?>

<h3>Il n'y a rien à voir ici</h3>

<a href="<?=$this->url('default_home')?>">< Retour à la page d'accueil</a>

<?php $this->stop('main_content'); ?>
