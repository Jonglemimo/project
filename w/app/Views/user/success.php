<?php $this->layout('layout', ['title' => 'Inscription réussie']);

$this->start('main_content') ?>
<ul>
    <li>Votre username : <?=$user['username']?></li>
    <li>Votre email : <?=$user['email']?></li>
</ul>
<a href="<?=$this->url('default_home')?>">Retour sur la page home</a>
<?php $this->stop('main_content')?>
