<?php $this->layout('layout', ['title' => 'Erreur 404','categories' => $categories]) ?>

<?php $this->start('main_content'); ?>

<h3>Perdu ?</h3>

<a href="<?=$this->url('default_home')?>">< Retour à la page d'accueil</a>

<?php $this->stop('main_content'); ?>
