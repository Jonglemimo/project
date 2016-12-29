<?php
$this->layout('layout', ['title' => 'Ma page']);
$this->start('main_content');
?>

<div class="userpage-banner">
    <img src="https://lh5.ggpht.com/DbMoJss0pR2-tKJdQaXiN2ZYwkHpTvfUSbjIYbc_zPlvGsnnLmJ5mHwwh_AnxbhFuks=w300" alt="Icône">

    <div>
        <p class="username"><?= $_SESSION['user']['username'] ?></p>
        <a href="<?=$this->url('user_info')?>">Mes infos</a>
        <a class="pull-right" href="<?=$this->url('upload_form')?>">Ajouter une vidéo</a
    </div>
</div>

>


<section class="container-fluid video-container">

    <h3>Mes dernières vidéos</h3>

    <?php if(is_array($videos)):?>

        <div class="row col-md-12">
            <?php foreach ($videos as $video):?>

                <div class="col-md-4">
                    <video class="video-medium" src="<?=$video['url']?>" controls poster="<?= $video['poster'] ?>"></video>
                    <h4><?=$video['title'] ?></h4>
                    <p><?= substr($video['description'], 0, 100); if(strlen($video['description']) > 100){ echo " [...]";} ?></p>
                </div>
            <?php endforeach;?>

        </div>

    <div>
        <a href="<?=$this->url('user_video')?>">Voir plus</a>
    </div>

    <?php else: echo $videos ?>
    <?php endif; ?>  
</section>

<section class="container-fluid comment-container">

    <h3>Mes derniers commentaires</h3>

    <?php if(isset($comments)):?>
        <?php foreach ($comments as $comment):?>

            <div class="col-md-6">
                <div class="col-sm-12 col-md-6">
                    <video class="video-small" src="<?=$video['url']?>" controls poster="<?= $video['poster'] ?>"></video>
                </div>

                <div class="video-comments col-sm-12 col-md-6">
                    <h5><p>Sur : </p><?=$comment['title'] ?></h5>
                    <p><?= substr($comment['content'], 0, 220); if(strlen($comment['content']) > 220){ echo " [...]";} ?></p>
                </div>
            </div>
        <?php endforeach;?>


    <div>
        <a href="<?=$this->url('user_comment')?>" class = "col-md-offset-7">Voir plus</a>
    </div>

        
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>